<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id('idCompany');
            $table->string('compName', 150);
            $table->timestamps();
        });

        // Insertar empresa UAQ
        DB::table('companies')->insert([
            'compName' => 'Universidad Autónoma de Querétaro',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};