<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'cust_name' => 'John Doe',
                'cust_email' => 'john@example.com',
                'cust_nohp' => '081234567890',
                'created_at' => now()
            ],
            [
                'cust_name' => 'Jane Smith',
                'cust_email' => 'jane@example.com',
                'cust_nohp' => '081234567891',
                'created_at' => now()
            ],
            [
                'cust_name' => 'Bob Johnson',
                'cust_email' => 'bob@example.com',
                'cust_nohp' => '081234567892',
                'created_at' => now()
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
