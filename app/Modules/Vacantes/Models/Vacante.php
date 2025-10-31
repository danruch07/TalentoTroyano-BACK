<?php

namespace App\Modules\Vacantes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    use HasFactory;

    protected $table = 'vacants';

    protected $primaryKey = 'idVacant';

    public $timestamps = false;

    protected $fillable = [
        'idModality',
        'idState',
        'idPrograms',
        'idAdmin',
        'idCompany',
        'title',
        'description',
        'requirements',
        'location',
        'typeContract',
        'salary',
        'schedule',
        'vacDate'
    ];

    protected $casts = [
        'salary' => 'decimal:2',
        'vacDate' => 'date',
    ];

    // Relación con postulaciones
    public function postulations()
    {
        return $this->hasMany(Postulation::class, 'idVacant', 'idVacant');
    }
    // FILTRADO
    
    public function scopeByState($query, $stateId)
    {
        return $query->where('idState', $stateId);
    }

    public function scopeByModality($query, $modalityId)
    {
        return $query->where('idModality', $modalityId);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('idCompany', $companyId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('location', 'like', "%{$term}%")
              ->orWhere('requirements', 'like', "%{$term}%");
        });
    }

    public function scopeByTypeContract($query, $type)
    {
        return $query->where('typeContract', $type);
    }

    public function scopeBySalaryRange($query, $min, $max = null)
    {
        $query->where('salary', '>=', $min);
        
        if ($max) {
            $query->where('salary', '<=', $max);
        }
        
        return $query;
    }
}