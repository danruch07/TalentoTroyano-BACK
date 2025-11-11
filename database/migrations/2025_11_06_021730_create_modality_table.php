<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('modality', function (Blueprint $table) {
            $table->id('idModality');
            $table->string('modName', 100);
            $table->timestamps();
        });

        // Datos iniciales
        DB::table('modality')->insert([
            ['modName' => 'Presencial', 'created_at' => now(), 'updated_at' => now()],
            ['modName' => 'Remoto', 'created_at' => now(), 'updated_at' => now()],
            ['modName' => 'Híbrido', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('modality');
    }
};