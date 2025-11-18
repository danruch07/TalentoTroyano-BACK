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
            $table->string('ubicacion', 255)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('industria', 100)->nullable();
            $table->string('rfc', 13)->nullable();
            $table->string('imagen', 255)->nullable(); // Ruta de la imagen de perfil
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};