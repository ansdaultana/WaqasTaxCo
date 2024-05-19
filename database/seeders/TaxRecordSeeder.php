<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\TaxRecord::factory()->create([
            'id'=>1,
             'year' => 2024,
             'min_income' => 0.00,
             'max_income'=>600000.00,
             'fixed_amount'=>null,
             'rate'=>0.00	
         ]);
        \App\Models\TaxRecord::factory()->create([
            'id'=>2,
             'year' => 2024,
             'min_income' => 600000.01,
             'fixed_amount'=>null,
             'max_income'=>1200000.00,
             'rate'=>2.50	
         ]);
         
        \App\Models\TaxRecord::factory()->create([
            'id'=>3,
             'year' => 2024,
             'min_income' => 1200000.01,
             'max_income'=>2400000.00,
             'rate'=>12.50,
             'fixed_amount'=>15000.00,		
         ]);
         
        \App\Models\TaxRecord::factory()->create([
            'id'=>4,
             'year' => 2024,
             'min_income' => 2400000.01,
             'max_income'=>3600000.00,
             'rate'=>22.50,
             'fixed_amount'=>165000.00,		
         ]);
         \App\Models\TaxRecord::factory()->create([
            'id'=>5,
             'year' => 2024,
             'min_income' => 3600000.01,
             'max_income'=>6000000.00,
             'rate'=>27.50	,
             'fixed_amount'=>	435000.00,		
         ]);
         \App\Models\TaxRecord::factory()->create([
            'id'=>6,
             'year' => 2024,
             'min_income' => 6000000.01,
             'max_income'=>null,
             'rate'=>35.00,
             'fixed_amount'=>1095000.00,		
         ]);
    }
}
