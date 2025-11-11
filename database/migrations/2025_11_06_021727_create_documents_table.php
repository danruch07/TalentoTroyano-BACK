<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('idDocument');
            $table->date('modDate')->nullable();
            $table->string('docRoute', 255)->nullable();
            $table->unsignedBigInteger('idUser');
            $table->timestamps();

            
            $table->foreign('idUser')
                  ->references('idUser')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};