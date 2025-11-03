<?php
namespace App\Modules\Usuarios\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable {
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'Users';
    protected $primaryKey = 'idUser';
    public $incrementing = true;
    protected $keyType = 'int';

    // Campos del DER
    protected $fillable = [
        'usName','usLastName','expedient','usBirthday',
        'usPhoneNumber','usEmail','usPassword','usProfilePicture',
    ];

    // Oculta hash
    protected $hidden = ['usPassword'];

    // Laravel espera "password" al autenticar con helpers tradicionales.
    // Nosotros autenticamos manualmente con usPassword, pero definimos accessor:
    public function getAuthPassword() { return $this->usPassword; }
}
