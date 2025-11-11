<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('idUser');
            $table->string('usName', 100);
            $table->string('usLastName', 100);
            $table->string('expedient', 50)->nullable();
            $table->date('usBirthday')->nullable();
            $table->string('usPhoneNumber', 20)->nullable();
            $table->string('usEmail', 100)->unique();
            $table->string('usPassword', 255);
            $table->string('usProfilePicture', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};