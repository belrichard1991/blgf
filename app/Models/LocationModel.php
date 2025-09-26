<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'municipalities'; // default table
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'province_id'];

    public function getProvinces()
    {
        return $this->db->table('provinces')->orderBy('name')->get()->getResultArray();
    }

    public function getMunicipalities()
    {
        return $this->db->table('municipalities')->orderBy('name')->get()->getResultArray();
    }

    public function getByProvinceGrouped()
    {
        $provinces = $this->getProvinces();
        $municipalities = $this->getMunicipalities();

        $grouped = [];

        foreach ($provinces as $province) {
            $grouped[$province['name']] = [];

            foreach ($municipalities as $muni) {
                if ($muni['province_id'] == $province['id']) {
                    $grouped[$province['name']][] = $muni;
                }
            }
        }

        return $grouped;
    }
    
    public function getMunicipalitiesByProvince($provinceId)
    {
        return $this->db->table('municipalities')
            ->where('province_id', $provinceId)
            ->orderBy('name')
            ->get()
            ->getResultArray();
    }

}
