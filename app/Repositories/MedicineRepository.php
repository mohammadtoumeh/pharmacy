<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Warehouse;
use App\Traits\GetPharmacistFromTokenTrait;
use App\Traits\GetWarehouseFromTokenTrait;
use App\Traits\StorePhotoTrait;
use Illuminate\Support\Facades\DB;

class MedicineRepository implements MedicineRepositoryInterface
{
    use StorePhotoTrait, GetWarehouseFromTokenTrait, GetPharmacistFromTokenTrait;

    protected Medicine $medicine;
    protected CategoryRepositoryInterface $categoryRepository;
    protected StatusMedicineRepositoryInterface $statusMedicineRepository;

    public function __construct(
        Medicine $medicine,
        CategoryRepositoryInterface $categoryRepository,
        StatusMedicineRepositoryInterface $statusMedicineRepository
    )
    {
        $this->medicine = $medicine;
        $this->categoryRepository = $categoryRepository;
        $this->statusMedicineRepository = $statusMedicineRepository;
    }

    public function index()
    {
        try {
            return $this->medicine->with('categories')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function indexForWarehouse()
    {
        try {
            return self::warehouse()->medicines()->with('categories', 'statusMedicine')->get()->makeVisible('quantity');
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function indexByCategory(int $id)
    {
        try {
            return Category::where('id', $id)->firstOrFail()->medicines()->with('categories')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function indexByWarehouse(int $id)
    {
        try {
            return Warehouse::where('id', $id)->firstOrFail()->medicines()->with('categories')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function indexByFavorit()
    {
        try {
            return self::pharmacist()->favoritMedicines()->with('categories')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }


    public function store(array $data)
    {

        try {
            DB::beginTransaction();

            $this->medicine->warehouse_id = self::warehouse()->id;
            $this->medicine->commercial_name = $data['commercial_name'];
            $this->medicine->scientific_name = $data['scientific_name'];
            $this->medicine->factory_name = $data['factory_name'];
            $this->medicine->price = $data['price'];
            $this->medicine->photo = isset($data['photo']) ? self::storePhoto($data['photo'], 'medicines-photos') : null;

            $this->medicine->save();

            $this->statusMedicineRepository->store($this->medicine, $data);

            if(isset($data['categories']))
            {
                $categoriesIdes = $this->categoryRepository->storeMultiple($data['categories']);
                $this->medicine->categories()->attach($categoriesIdes);
            }

            DB::commit();
            return $this->medicine->load('categories', 'statusMedicine');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }


    public function show(int $id)
    {
        try {
            return $this->medicine->where('id', $id)->with('categories')->firstOrFail();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function showForWarehouse(int $id)
    {
        try {
            return self::warehouse()->medicines()->where('id', $id)->with('categories', 'statusMedicine')->firstOrFail()->makeVisible('quantity');
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }


    public function update(Medicine $medicine, array $data)
    {
        try {
            DB::beginTransaction();

            $this->medicine = $medicine;

            $this->medicine->commercial_name = $data['commercial_name'] ?? $this->medicine->commercial_name;
            $this->medicine->scientific_name = $data['scientific_name'] ?? $this->medicine->scientific_name;
            $this->medicine->factory_name = $data['factory_name'] ?? $this->medicine->factory_name;
            $this->medicine->price = $data['price'] ?? $this->medicine->price;

            $this->medicine->save();

            if(isset($data['categories']))
            {
                $categoriesIdes = $this->categoryRepository->storeMultiple($data['categories']);
                $this->medicine->categories()->sync($categoriesIdes);
            }
            else
                $this->medicine->categories()->detach();

            DB::commit();
            return $this->medicine->load('categories', 'statusMedicine');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
//
    }

    public function destroy(Medicine $medicine)
    {
        $this->medicine = $medicine;

        $this->medicine->delete();
    }


    public function search(string $search)
    {
        try {
            return $this->medicine
                ->where('commercial_name', 'like', '%' . $search . '%')
                ->orwhere('scientific_name', 'like', '%' . $search . '%')
                ->with('categories')->get();

        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function addToFavorit(int $id)
    {
        try {
            $this->medicine->where('id', $id)->firstOrFail();

            if(self::pharmacist()->favoritMedicines()->where('id', $id)->exists())
            {
                self::pharmacist()->favoritMedicines()->detach($id);
                return 'medicine removed from favorit';
            }
            else
            {
                self::pharmacist()->favoritMedicines()->attach($id);
                return 'medicine added to favorit';
            }
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

}
