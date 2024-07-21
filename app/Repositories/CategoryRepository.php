<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        try {
            return $this->category->all();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function storeMultiple(array $categoriesNames)
    {
        try {
            $categoriesIdes = collect($categoriesNames)
                ->map(function ($categoryName) {
                return $this->category->firstOrCreate(['name' => $categoryName])->id;
            });

            return $categoriesIdes;
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }


}
