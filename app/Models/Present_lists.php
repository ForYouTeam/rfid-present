<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Present_lists extends Model
{

    use HasFactory;
    protected $fillable = [
        'present_date', 'start_in', 'start_out', 'employe_id', 'status', 'grouping_by', 'description', 
        'created_at', 'updated_at', 
    ];

    public function scopebyFilter($query, array $payload) {
        if (count($payload) >= 1 && isset($payload['search'])) {
            $searchTerm = $payload['search'];
            $query->where(function($query) use ($searchTerm) {
                $query->whereDate('present_date', '=', $searchTerm)
                      ->orWhereTime('start_in', '=', $searchTerm)
                      ->orWhereTime('start_out', '=', $searchTerm)
                      ->orWhere('employe_rfid', 'LIKE', "%".$searchTerm."%")
                      ->orWhere('employe_name', 'LIKE', "%".$searchTerm."%")
                      ->orWhere('employe_nirp', 'LIKE', "%".$searchTerm."%");
            });
        }
        if (count($payload) >= 1 && isset($payload['group_by'])) {
            $query->groupBy($payload['group_by']);
        }
        return $query;
    }

    public function scopewithRelation($query) {
        return $query
            ->leftJoin('employes as m1', 'present_lists.employe_id', 'm1.id')
            ->leftJoin('satkers as m2', 'present_lists.grouping_by', 'm2.id')
            ->select(
                'present_lists.id',
                'present_lists.present_date',
                'present_lists.start_in',
                'present_lists.start_out',
                'present_lists.employe_id',
                'present_lists.status',
                'm1.rfid as employe_rfid',
                'm1.name as employe_name',
                'm1.nirp as employe_nirp',
                'present_lists.grouping_by',
                'present_lists.description',
                'm2.name as satker',
                'present_lists.created_at',
                'present_lists.updated_at',
            );
    }
}
