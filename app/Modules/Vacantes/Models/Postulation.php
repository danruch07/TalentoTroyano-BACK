<?php

namespace App\Modules\Vacantes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status'
    ];

    protected $casts = [
        'postDate' => 'date',
    ];

    // Relaciones
    public function vacante()
    {
        return $this->belongsTo(Vacante::class, 'idVacant', 'idVacant');
    }

    public function user()
    {
        return $this->belongsTo(\App\Modules\Users\Models\User::class, 'idUser');
    }

    public function state()
    {
        return $this->belongsTo(\App\Modules\States\Models\State::class, 'idState');
    }

    public function admin()
    {
        return $this->belongsTo(\App\Modules\Admins\Models\Admin::class, 'idAdmin');
    }

    public function modality()
    {
        return $this->belongsTo(\App\Modules\Modalities\Models\Modality::class, 'idModality');
    }

    public function company()
    {
        return $this->belongsTo(\App\Modules\Companies\Models\Company::class, 'idCompany');
    }

    public function program()
    {
        return $this->belongsTo(\App\Modules\Programs\Models\Program::class, 'idPrograms');
    }
}