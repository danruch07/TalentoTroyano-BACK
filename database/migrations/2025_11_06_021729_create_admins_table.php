<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('idAdmin');
            $table->unsignedBigInteger('idCompany');
            $table->string('adName', 100);
            $table->string('adLastName', 100);
            $table->string('adEmail', 100)->unique();
            $table->string('adPassword', 255);
            $table->string('adPhoneNumber', 20)->nullable();
            $table->string('adProfilePicture', 255)->nullable();
            $table->timestamps();

            
            $table->foreign('idCompany')
                  ->references('idCompany')
                  ->on('companies')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};