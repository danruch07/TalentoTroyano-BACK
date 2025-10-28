<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $primaryKey = 'doc_id';

    protected $fillable = [
        'owner_user_id','doc_type','original_name','file_name','file_path',
        'mime_type','file_size','sha256','application_id'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    // Cuando se integre Applications:
    public function application() {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
