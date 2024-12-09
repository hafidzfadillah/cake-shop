<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'prod_name' => 'Chocolate Cake',
                'prod_desc' => 'Rich chocolate cake with chocolate ganache',
                'prod_price' => 250000,
                'prod_price_promo' => 225000,
                'prod_stock' => 10,
                'prod_img_url' => 'https://example.com/chocolate-cake.jpg',
                'prod_category_id' => 1,
                'created_at' => now()
            ],
            [
                'prod_name' => 'Chocolate Chip Cookies',
                'prod_desc' => 'Classic cookies with chocolate chips',
                'prod_price' => 50000,
                'prod_price_promo' => 45000,
                'prod_stock' => 50,
                'prod_img_url' => 'https://example.com/choc-chip-cookies.jpg',
                'prod_category_id' => 2,
                'created_at' => now()
            ],
            [
                'prod_name' => 'Sourdough Bread',
                'prod_desc' => 'Artisanal sourdough bread',
                'prod_price' => 75000,
                'prod_price_promo' => 70000,
                'prod_stock' => 15,
                'prod_img_url' => 'https://example.com/sourdough.jpg',
                'prod_category_id' => 3,
                'created_at' => now()
            ],
            [
                'prod_name' => 'Croissant',
                'prod_desc' => 'Buttery French croissant',
                'prod_price' => 25000,
                'prod_price_promo' => 22000,
                'prod_stock' => 30,
                'prod_img_url' => 'https://example.com/croissant.jpg',
                'prod_category_id' => 4,
                'created_at' => now()
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
