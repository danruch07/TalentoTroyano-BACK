<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vacants', function (Blueprint $table) {
            $table->id('idVacant');
            $table->unsignedBigInteger('idModality');
            $table->unsignedBigInteger('idState');
            $table->unsignedBigInteger('idPrograms');
            $table->unsignedBigInteger('idAdmin');
            $table->unsignedBigInteger('idCompany');
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->string('location', 150)->nullable();
            $table->string('typeContract', 100)->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('schedule', 100)->nullable();
            $table->date('vacDate')->nullable();
            $table->timestamps();

            
            $table->foreign('idModality')
                  ->references('idModality')
                  ->on('modality')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idState')
                  ->references('idState')
                  ->on('states')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idPrograms')
                  ->references('idPrograms')
                  ->on('programs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idAdmin')
                  ->references('idAdmin')
                  ->on('admins')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idCompany')
                  ->references('idCompany')
                  ->on('companies')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacants');
    }
};