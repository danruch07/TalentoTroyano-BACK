<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('idNotification');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idMess');
            $table->dateTime('notDate')->useCurrent();
            $table->boolean('read')->default(false);
            
            $table->foreign('idUser')
                  ->references('idUser')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('idMess')
                  ->references('idMess')
                  ->on('messages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};