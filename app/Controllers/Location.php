<?php 
// app/Controllers/Location.php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LocationModel;

class Location extends BaseController
{
    public function getProvinces()
    {
        $model = new LocationModel();
        $provinces = $model->getProvinces();
        return $this->response->setJSON($provinces);
    }

    public function getMunicipalities($provinceId)
    {
        $model = new LocationModel();
        $municipalities = $model->getMunicipalitiesByProvince($provinceId);
        return $this->response->setJSON($municipalities);
    }
}

?>