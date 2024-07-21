<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Medicine;
use App\Models\Pharmacist;
use App\Models\Role;
use App\Models\State;
use App\Models\StatusMedicine;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
                DB::beginTransaction();

                User::factory(2)
                    ->has(Warehouse::factory()
                        ->hasAttached([
                            State::find(random_int(1,5)),
                            State::find(random_int(6,9)),
                        ])
                        ->has(Employee::factory(3))
                        ->has(Medicine::factory(3)
                            ->has(Category::factory(2))
                            ->has(StatusMedicine::factory(2))
                            ->afterCreating(function ($medicine){
                                $medicine->update([
                                    'quantity' => $medicine->statusMedicine()->sum('quantity')
                                ]);
                            })
                        )
                    )
                    ->create([
                    'user_type' => 'warehouse'
                ]);

                User::factory(2)
                    ->has(Pharmacist::factory())
                    ->create([
                        'user_type' => 'pharmacist'
                    ]);

                DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
