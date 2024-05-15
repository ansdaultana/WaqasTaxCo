<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Price::factory()->create([
            'id'=>1,
             'service_name' => 'NTN',
             'price' => 5000,
         ]);
    }
}
