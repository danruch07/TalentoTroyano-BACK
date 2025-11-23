<?php

namespace App\Modules\Usuarios\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Tabla física en base de datos.
     * Se unifica con la migración create_users_table (tabla 'users').
     */
    protected $table = 'users';

    protected $primaryKey = 'idUser';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Campos que se pueden asignar en masa.
     */
    protected $fillable = [
        'usName',
        'usLastName',
        'expedient',
        'usBirthday',
        'usPhoneNumber',
        'usEmail',
        'usPassword',
        'usDescriition',
        'usProfilePicture',
    ];

    /**
     * Campos ocultos al serializar a JSON.
     */
    protected $hidden = [
        'usPassword',
        'remember_token',
    ];

    /**
     * Accessor requerido por Laravel para password.
     */
    public function getAuthPassword()
    {
        return $this->usPassword;
    }

    /**
     * Relación: documentos (CV, etc.) del usuario.
     */
    public function documentos()
    {
        return $this->hasMany(\App\Modules\Documentos\Models\Documento::class, 'idUser', 'idUser');
    }

    /**
     * Relación: postulaciones a vacantes.
     */
    public function postulations()
    {
        return $this->hasMany(\App\Modules\Vacantes\Models\Postulation::class, 'idUser', 'idUser');
    }
}

