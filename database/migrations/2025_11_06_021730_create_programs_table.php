<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id('idPrograms');
            $table->string('prName', 150);
            $table->timestamps();
        });

        // Datos iniciales
        DB::table('programs')->insert([
            ['prName' => 'Ingeniería de Software', 'created_at' => now(), 'updated_at' => now()],
            ['prName' => 'Licenciatura en administración de las T.I.', 'created_at' => now(), 'updated_at' => now()],
            ['prName' => 'Licenciatura en informática', 'created_at' => now(), 'updated_at' => now()],
            ['prName' => 'Ingeniería en Tecnologías de la Información y Ciberseguridad', 'created_at' => now(), 'updated_at' => now()],
            ['prName' => 'Ingeniería en Ciencia y Analítica de Datos', 'created_at' => now(), 'updated_at' => now()],
            ['prName' => 'Ingeniería en Telecomunicaciones y Redes', 'created_at' => now(), 'updated_at' => now()],
            ['prName' => 'Ingeniería en Computación', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
};