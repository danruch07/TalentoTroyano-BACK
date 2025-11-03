<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Crea la tabla EXACTA del DER
        if (!Schema::hasTable('Users')) {
            Schema::create('Users', function (Blueprint $t) {
                $t->bigIncrements('idUser');               // PK
                $t->string('usName', 120);
                $t->string('usLastName', 120);
                $t->string('expedient', 30)->nullable();
                $t->date('usBirthday')->nullable();
                $t->string('usPhoneNumber', 30)->nullable();
                $t->string('usEmail', 180)->unique();
                $t->string('usPassword');                   // hash
                $t->string('usProfilePicture', 255)->nullable();
                $t->timestamps();                           // opcional extra
            });
        }
    }
    public function down(): void { Schema::dropIfExists('Users'); }
};
