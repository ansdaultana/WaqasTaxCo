<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'id'=>1,
             'name' => 'Ans Daultana',
             'email' => 'ansdaultana.ad5@gmail.com',
             'password'=>bcrypt('12121212'),
             'phone_no'=>'03005378032',
             'cnic'=>'31203-8250415-3',
         ]);
    }
}
