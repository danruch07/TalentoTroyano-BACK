<?php

namespace App\Modules\Companies\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminCompany extends Model
{
    use HasFactory;

    protected $table = 'admins';
    protected $primaryKey = 'idAdmin';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'idCompany',
        'adName',
        'adLastName',
        'adEmail',
        'adPassword',
        'adPhoneNumber',
        'adProfilePicture',
    ];

    protected $hidden = [
        'adPassword',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'idCompany', 'idCompany');
    }
}

