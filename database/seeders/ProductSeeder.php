<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Product 1',
            'description' => 'Description for product 1',
            'price' => 10.00,
        ]);
        DB::table('products')->insert([
            'name' => 'Product 2',
            'description' => 'Description for product 2',
            'price' => 20.00,
        ]);
        DB::table('products')->insert([
            'name' => 'Product 3',
            'description' => 'Description for product 3',
            'price' => 30.00,
        ]);
        DB::table('products')->insert([
            'name' => 'Product 4',
            'description' => 'Description for product 4',
            'price' => 40.00,
        ]);
    }
}
