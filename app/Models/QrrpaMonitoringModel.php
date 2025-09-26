<?php

namespace App\Models;

use CodeIgniter\Model;

class QrrpaMonitoringModel extends Model
{
    protected $table = 'qrrpa_monitoring';
    protected $primaryKey = 'id';
    protected $allowedFields = ['municipality_id', 'year', 'quarter', 'is_evaluated', 'updated_at'];

    public function getMonitoringStatus($year, $quarter)
    {
        return $this->where('year', $year)
                    ->where('quarter', $quarter)
                    ->findAll();
    }
}
