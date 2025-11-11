<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vacants', function (Blueprint $table) {
            // Índices simples para filtros comunes
            $table->index('idState');
            $table->index('idModality');
            $table->index('idCompany');
            $table->index('idPrograms');
            $table->index('typeContract');
            $table->index('vacDate');
            $table->index('salary');
            
            // Índice compuesto para consultas frecuentes
            $table->index(['idState', 'vacDate', 'idCompany'], 'idx_state_date_company');
            
            // Índice para búsquedas de texto
            $table->index('location');
        });
    }

    public function down(): void
    {
        Schema::table('vacants', function (Blueprint $table) {
            $table->dropIndex(['idState']);
            $table->dropIndex(['idModality']);
            $table->dropIndex(['idCompany']);
            $table->dropIndex(['idPrograms']);
            $table->dropIndex(['typeContract']);
            $table->dropIndex(['vacDate']);
            $table->dropIndex(['salary']);
            $table->dropIndex('idx_state_date_company');
            $table->dropIndex(['location']);
        });
    }
};