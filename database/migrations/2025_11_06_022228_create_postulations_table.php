<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('postulations', function (Blueprint $table) {
            $table->id('idPostulation');
            $table->unsignedBigInteger('idVacant');
            $table->unsignedBigInteger('idState');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idAdmin');
            $table->unsignedBigInteger('idModality');
            $table->unsignedBigInteger('idCompany');
            $table->unsignedBigInteger('idPrograms');
            $table->dateTime('postDate')->useCurrent();
            $table->enum('status', ['Pendiente', 'Aceptada', 'Rechazada'])->default('Pendiente');
            
            $table->foreign('idVacant')
                  ->references('idVacant')
                  ->on('vacants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idState')
                  ->references('idState')
                  ->on('states')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idUser')
                  ->references('idUser')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idAdmin')
                  ->references('idAdmin')
                  ->on('admins')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idModality')
                  ->references('idModality')
                  ->on('modality')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idCompany')
                  ->references('idCompany')
                  ->on('companies')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idPrograms')
                  ->references('idPrograms')
                  ->on('programs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('postulations');
    }
};