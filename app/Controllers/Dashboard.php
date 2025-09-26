<?php

namespace App\Controllers;
use App\Models\EmployeeModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new EmployeeModel();

        $provinceCounts = $model
            ->select('province, COUNT(*) as total')
            ->groupBy('province')
            ->findAll();

        $positionCounts = $model
            ->select('plantilla_position, COUNT(*) as total')
            ->groupBy('plantilla_position')
            ->findAll();

        // *** NEW: gender counts ***
        $genderRaw = $model
            ->select('gender, COUNT(*) as total')
            ->groupBy('gender')
            ->findAll();

        // Convert to ['M' => x, 'F' => y]
        $genderCounts = [];
        foreach ($genderRaw as $row) {
            $genderCounts[$row['gender']] = (int)$row['total'];
        }

        $data = [
            'provinceCounts' => $provinceCounts,
            'positionCounts' => $positionCounts,
            'genderCounts'   => $genderCounts,   // pass to view
        ];

        return view('employee/dashboard', $data);
    }
}