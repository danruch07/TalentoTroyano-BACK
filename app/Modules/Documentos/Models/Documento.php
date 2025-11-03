<?php
namespace App\Modules\Documentos\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Usuarios\Models\Usuario;

class Documento extends Model {
    protected $table = 'Documents';
    protected $primaryKey = 'idDocument';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['modDate','docRoute','idUser'];

    public function usuario(){ return $this->belongsTo(Usuario::class, 'idUser', 'idUser'); }
}
