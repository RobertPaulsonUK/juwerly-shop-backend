<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOption;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(20)->create();
         Attribute::factory(10)
             ->has(AttributeOption::factory(rand(5,10)),'options')
             ->create();
         ProductCategory::factory(10)
                        ->has(Product::factory(rand(10,15)))
                        ->create();

    }
}
