<?php

namespace App\Models;

use CodeIgniter\Model;

class Smv_model extends Model
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

    public function getLocationsByType($type)
    {
        return $this->db->table('locations')
            ->where('type', $type)
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function calculateLocationProgress($locationId)
    {
        $totalActivities = $this->db->table('activities')->countAllResults();
        if ($totalActivities == 0) return 0;

        $completed = $this->where('location_id', $locationId)
                          ->where('status', 'Completed')
                          ->countAllResults();

        return round(($completed / $totalActivities) * 100, 2);
    }

    public function getLocationActivities($locationId)
    {
        return $this->db->table('location_activities')
            ->select('location_activities.id, activities.name AS activity, location_activities.status, location_activities.date_completed, location_activities.remarks')
            ->join('activities', 'activities.id = location_activities.activity_id')
            ->where('location_activities.location_id', $locationId)
            ->orderBy('activities.category_id', 'ASC')
            ->orderBy('activities.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getSummaryData()
    {
        $locations = $this->db->table('locations')
            ->select('id, name, type, posting_date, hearing_date')
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->getResultArray();

        $totalActivities = $this->db->table('activities')->countAllResults();
        $summary = [];

        foreach ($locations as $loc) {
            $completed = $this->where('location_id', $loc['id'])->where('status', 'Completed')->countAllResults();
            $pending = $totalActivities - $completed;

            $summary[] = [
                'name' => $loc['name'],
                'type' => $loc['type'],
                'posting_date' => $loc['posting_date'],
                'hearing_date' => $loc['hearing_date'],
                'total' => $totalActivities,
                'completed' => $completed,
                'pending' => $pending,
                'percentage' => $totalActivities > 0 ? round(($completed / $totalActivities) * 100, 2) : 0
            ];
        }

        return $summary;
    }
    
    public function getAllLocations()
    {
        return $this->db->table('locations')
            ->select('id, name, type, province_id')
            ->get()
            ->getResultArray();
    }

}
