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
                'compName' => 'Universidad Autónoma de Querétaro',
                'ubicacion' => 'Cerro de las Campanas s/n, Las Campanas, 76010 Santiago de Querétaro, Qro.',
                'telefono' => '442 192 1200',
                'email' => 'contacto@uaq.mx',
                'descripcion' => 'Institución pública de educación superior comprometida con la formación integral de profesionales.',
                'industria' => 'Educación',
                'rfc' => 'UAQ850101ABC',
                'imagen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'compName' => 'Tech Solutions SA',
                'ubicacion' => 'Av. Constituyentes 100, Querétaro',
                'telefono' => '442 123 4567',
                'email' => 'contacto@techsolutions.com',
                'descripcion' => 'Empresa líder en desarrollo de software y soluciones tecnológicas.',
                'industria' => 'Tecnología',
                'rfc' => 'TSO200515XYZ',
                'imagen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'compName' => 'Innovación Digital',
                'ubicacion' => 'Blvd. Bernardo Quintana 200, Querétaro',
                'telefono' => '442 987 6543',
                'email' => 'info@innovaciondigital.com',
                'descripcion' => 'Especialistas en transformación digital y consultoría tecnológica.',
                'industria' => 'Consultoría',
                'rfc' => 'IND180320DEF',
                'imagen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Admins (uno por empresa)
        DB::table('admins')->insert([
            [
                'idCompany' => 1, // UAQ
                'adName' => 'Administrador',
                'adLastName' => 'UAQ',
                'adEmail' => 'admin@uaq.mx',
                'adPassword' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idCompany' => 2, // Tech Solutions
                'adName' => 'Carlos',
                'adLastName' => 'Martínez',
                'adEmail' => 'carlos@techsolutions.com',
                'adPassword' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idCompany' => 3, // Innovación Digital
                'adName' => 'Ana',
                'adLastName' => 'López',
                'adEmail' => 'ana@innovaciondigital.com',
                'adPassword' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}