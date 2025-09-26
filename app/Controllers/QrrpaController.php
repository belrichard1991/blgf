<?php

namespace App\Controllers;

use App\Models\LocationModel;
use App\Models\QrrpaMonitoringModel;

class QrrpaController extends BaseController
{
    public function index()
    {
        $year = $this->request->getGet('year') ?? date('Y');
        $quarter = $this->request->getGet('quarter') ?? ceil(date('n') / 3);

        $locationModel = new LocationModel();
        $monitoringModel = new QrrpaMonitoringModel();

        $grouped = $locationModel->getByProvinceGrouped();
        $monitoring = $monitoringModel->getMonitoringStatus($year, $quarter);

        $evaluatedIds = array_column(
            array_filter($monitoring, fn($row) => $row['is_evaluated'] == 2),
            'municipality_id'
        );

        return view('qrrpa/index', [
            'title' => 'QRRPA Monitoring',
            'year' => $year,
            'quarter' => $quarter,
            'grouped' => $grouped,
            'evaluatedIds' => $evaluatedIds
        ]);
    }

    public function result()
    {
        $year = $this->request->getPost('year');
        $quarter = $this->request->getPost('quarter');
        $checked = $this->request->getPost('evaluated') ?? [];

        $monitoringModel = new QrrpaMonitoringModel();
        $locationModel = new LocationModel();

        $municipalities = $locationModel->getMunicipalities();
        $provinces = $locationModel->getProvinces();

        // Clear existing entries
        $monitoringModel->where('year', $year)
                        ->where('quarter', $quarter)
                        ->delete();

        // Save all municipalities with correct status
        foreach ($municipalities as $muni) {
            $monitoringModel->insert([
                'municipality_id' => $muni['id'],
                'year' => $year,
                'quarter' => $quarter,
                'is_evaluated' => in_array($muni['id'], $checked) ? 2 : 3,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Build stats per province
        $provinceMap = [];
        foreach ($provinces as $p) {
            $provinceMap[$p['id']] = $p['name'];
        }

        $stats = [];
        foreach ($municipalities as $muni) {
            $provinceName = $provinceMap[$muni['province_id']] ?? 'Unknown';

            if (!isset($stats[$provinceName])) {
                $stats[$provinceName] = ['done' => 0, 'total' => 0, 'percent' => 0];
            }

            $stats[$provinceName]['total']++;
            if (in_array($muni['id'], $checked)) {
                $stats[$provinceName]['done']++;
            }
        }

        foreach ($stats as &$data) {
            $data['percent'] = $data['total'] > 0
                ? round(($data['done'] / $data['total']) * 100, 2)
                : 0;
        }

        return view('qrrpa/result', [
            'title' => 'QRRPA Monitoring Results',
            'year' => $year,
            'quarter' => $quarter,
            'stats' => $stats
        ]);
    }

    public function summary()
    {
        $monitoringModel = new \App\Models\QrrpaMonitoringModel();
        $locationModel = new \App\Models\LocationModel();

        $monitoringData = $monitoringModel->findAll();
        $provinces = $locationModel->getProvinces();
        $municipalities = $locationModel->getMunicipalities();

        $provinceMap = [];
        foreach ($provinces as $p) {
            $provinceMap[$p['id']] = $p['name'];
        }

        $summary = [];

        foreach ($monitoringData as $row) {
            $year = $row['year'];
            $quarter = $row['quarter'];
            $muniId = $row['municipality_id'];

            $muni = array_filter($municipalities, fn($m) => $m['id'] == $muniId);
            $muni = reset($muni);
            $provinceId = $muni['province_id'] ?? null;
            $provinceName = $provinceMap[$provinceId] ?? 'Unknown';

            if (!isset($summary[$year][$quarter][$provinceName])) {
                $summary[$year][$quarter][$provinceName] = ['done' => 0, 'total' => 0];
            }

            $summary[$year][$quarter][$provinceName]['done'] += ($row['is_evaluated'] == 2 ? 1 : 0);
            $summary[$year][$quarter][$provinceName]['total'] += 1;
        }

        // ✅ Ensure 'percent' is calculated for every province
        foreach ($summary as $year => $quarters) {
            foreach ($quarters as $quarter => $provinces) {
                foreach ($provinces as $province => &$data) {
                    $data['percent'] = ($data['total'] > 0)
                        ? round(($data['done'] / $data['total']) * 100, 2)
                        : 0;
                }
            }
        }

        return view('qrrpa/summary', [
            'summary' => $summary,
            'selectedYear' => $_GET['year'] ?? array_key_first($summary),
            'selectedQuarter' => $_GET['quarter'] ?? 'ALL'
        ]);

    }

}
