<?php

namespace App\Models;

use CodeIgniter\Model;

class RpvaraModel extends Model
{
    protected $table = 'location_activities';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'location_id',
        'activity_id',
        'status',
        'date_completed',
        'remarks'
    ];

   public function getActivitiesByLocation($locationId)
    {
        return $this->db->table('location_activities')
            ->select('
                location_activities.id,
                location_activities.status,
                location_activities.date_completed,
                location_activities.remarks,
                activities.name AS activity_name,
                activities.category_id,
                smv_categories.name AS category_name
            ')
            ->join('activities', 'activities.id = location_activities.activity_id')
            ->join('smv_categories', 'smv_categories.id = activities.category_id')
            ->where('location_activities.location_id', $locationId)
            ->orderBy('activities.category_id', 'ASC')
            ->orderBy('activities.id', 'ASC')
            ->get()
            ->getResultArray();
    }



    public function calculateProgress($locationId)
    {
        $totalActivities = $this->db->table('activities')->countAllResults();
        if ($totalActivities == 0) return 0;

        $completed = $this->where('location_id', $locationId)
                          ->where('status', 'Completed')
                          ->countAllResults();

        return round(($completed / $totalActivities) * 100, 2);
    }

    public function getLocations()
    {
        return $this->db->table('locations')
            ->select('id, name, type, posting_date, hearing_date')
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->getResultArray();
    }

    public function getProgress($locationId)
    {
        $totalActivities = $this->db->table('activities')->countAllResults();

        if ($totalActivities === 0) {
            return ['done' => 0, 'total' => 0, 'percent' => 0];
        }

        $completed = $this->where('location_id', $locationId)
                        ->where('status', 'Completed')
                        ->countAllResults();

        return [
            'done' => $completed,
            'total' => $totalActivities,
            'percent' => round(($completed / $totalActivities) * 100, 2)
        ];
    }

}
