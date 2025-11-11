<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id('idStatistics');
            $table->unsignedBigInteger('idCompany');
            $table->unsignedBigInteger('idAdmin');
            $table->string('staName', 150)->nullable();
            $table->date('date')->nullable();
            
            $table->foreign('idCompany')
                  ->references('idCompany')
                  ->on('companies')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idAdmin')
                  ->references('idAdmin')
                  ->on('admins')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('statistics');
    }
};