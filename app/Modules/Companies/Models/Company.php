<?php

namespace App\Modules\Companies\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $primaryKey = 'idCompany';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'compName',
        'ubicacion',
        'telefono',
        'email',
        'descripcion',
        'industria',
        'rfc',
        'imagen',
    ];

    public function admins()
    {
        return $this->hasMany(AdminCompany::class, 'idCompany', 'idCompany');
    }
}

