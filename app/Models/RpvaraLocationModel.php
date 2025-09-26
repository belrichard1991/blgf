<?php
namespace App\Models;

use CodeIgniter\Model;

class RpvaraLocationModel extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'type', 'region_id'];

    public function getAll()
    {
        return $this->orderBy('name')->findAll();
    }

    public function getByRegion($regionId)
    {
        return $this->where('region_id', $regionId)->orderBy('name')->findAll();
    }
}
