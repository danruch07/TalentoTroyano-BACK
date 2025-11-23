<?php

namespace App\Modules\Vacantes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Vacantes\Models\Vacante;
use App\Modules\Usuarios\Models\Usuario;

class Postulation extends Model
{
    use HasFactory;

    protected $table = 'postulations';
    protected $primaryKey = 'idPostulation';
    public $timestamps = false;

    protected $fillable = [
        'idVacant',
        'idState',
        'idUser',
        'idAdmin',
        'idModality',
        'idCompany',
        'idPrograms',
        'postDate',
        'status',
    ];

    protected $casts = [
        'postDate' => 'datetime',
    ];

    // Relaciones

    public function vacante()
    {
        return $this->belongsTo(Vacante::class, 'idVacant', 'idVacant');
    }

    public function user()
    {
        // Usa tu modelo modular de usuarios
        return $this->belongsTo(Usuario::class, 'idUser', 'idUser');
    }

    public function state()
    {
        return $this->belongsTo(\App\Modules\States\Models\State::class, 'idState');
    }

    public function admin()
    {
        return $this->belongsTo(\App\Modules\Companies\Models\AdminCompany::class, 'idAdmin', 'idAdmin');
    }

    public function modality()
    {
        return $this->belongsTo(\App\Modules\Modalities\Models\Modality::class, 'idModality');
    }

    public function company()
    {
        return $this->belongsTo(\App\Modules\Companies\Models\Company::class, 'idCompany', 'idCompany');
    }

    public function program()
    {
        return $this->belongsTo(\App\Modules\Programs\Models\Program::class, 'idPrograms', 'idPrograms');
    }
}

