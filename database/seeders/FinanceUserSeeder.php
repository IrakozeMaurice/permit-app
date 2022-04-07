<?php

namespace Database\Seeders;

use App\Models\FinanceUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FinanceUserSeeder extends Seeder
{
    public function run()
    {
        //create finance user
        FinanceUser::insert([
            [
                'name' => 'finance user',
                'email' => 'finance@example.com',
                'password' => Hash::make('aaaaaaaa'), // aaaaaaaa
            ]
        ]);
    }
}
