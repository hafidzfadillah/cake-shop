<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['prod_category_name' => 'Cakes', 'created_at' => now()],
            ['prod_category_name' => 'Cookies', 'created_at' => now()],
            ['prod_category_name' => 'Breads', 'created_at' => now()],
            ['prod_category_name' => 'Pastries', 'created_at' => now()],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
