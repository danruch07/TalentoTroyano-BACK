<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // Companies
        DB::table('companies')->insert([
            [
                'compName' => 'Tech Solutions SA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'compName' => 'Innovación Digital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Admins
        DB::table('admins')->insert([
            [
                'idCompany' => 2,
                'adName' => 'Test',
                'adLastName' => 'Admin',
                'adEmail' => 'test@uaq.mx',
                'adPassword' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


    }
}