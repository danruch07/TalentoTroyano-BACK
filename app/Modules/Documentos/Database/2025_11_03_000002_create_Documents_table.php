<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('Documents')) {
            Schema::create('Documents', function (Blueprint $t) {
                $t->bigIncrements('idDocument');                   // PK
                $t->timestamp('modDate')->useCurrent();            // fecha de modificación
                $t->string('docRoute', 500);                       // ruta/archivo guardado
                $t->unsignedBigInteger('idUser');                  // FK Users.idUser
                $t->timestamps();

                $t->foreign('idUser')->references('idUser')->on('Users')->cascadeOnDelete();
            });
        }
    }
    public function down(): void { Schema::dropIfExists('Documents'); }
};
