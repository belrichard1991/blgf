<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationActivityModel extends Model
{
    protected $table = 'location_activities';
    protected $primaryKey = 'id';
    protected $allowedFields = ['location_id', 'activity_name', 'is_evaluated', 'created_at', 'updated_at'];
}
