<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id('idState');
            $table->string('stName', 100);
            $table->timestamps();
        });

        // Datos iniciales
        DB::table('states')->insert([
            ['stName' => 'Activo', 'created_at' => now(), 'updated_at' => now()],
            ['stName' => 'Pausado', 'created_at' => now(), 'updated_at' => now()],
            ['stName' => 'Cerrado', 'created_at' => now(), 'updated_at' => now()],
            ['stName' => 'En revisión', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('states');
    }
};