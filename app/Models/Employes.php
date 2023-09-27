<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employes extends Model
{
    use HasFactory;
    protected $fillable = [
        'rfid', 'name', 'nirp', 'nik', 'sex', 'position_id', 'satker_id', 'kls',
        'created_at', 'updated_at'
    ];

    public function scopewithRelation($query) {
        return $query
            ->leftJoin('positions as m1', 'employes.position_id', 'm1.id')
            ->leftJoin('satkers as m2', 'employes.satker_id', 'm2.id')
            ->select(
                'employes.rfid',
                'employes.name',
                'employes.nirp',
                'employes.nik',
                'employes.sex',
                'employes.position_id',
                'm1.name as position',
                'employes.satker_id',
                'm2.name as satker',
                'employes.created_at',
                'employes.updated_at',
            );
    }
}
