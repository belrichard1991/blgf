<?php

namespace App\Controllers;

use App\Models\Smv_model;

class Smv extends BaseController
{
    protected $smvModel;

    public function __construct()
    {
        $this->smvModel = new Smv_model();
    }

   public function index()
    {
        $data['title'] = 'SMV Monitoring';
        $data['header'] = 'SMV Dashboard';

        // Get all locations
        $locations = $this->smvModel->getAllLocations(); // includes type and province_id

        // Separate provinces and cities
        $provinces = array_filter($locations, fn($loc) => $loc['type'] === 'Province');
        $cities = array_filter($locations, fn($loc) => $loc['type'] === 'City');

        // Combine provinces and cities for top-level display
        $topLocations = array_merge($provinces, $cities);
        $data['topLocations'] = $topLocations;

        $progress = [];

        // Add provinces to progress
        foreach ($provinces as $province) {
            $provinceId = $province['id'];
            $provinceName = $province['name'];

            $provinceProgress = $this->smvModel->calculateLocationProgress($provinceId);
            $provinceActivities = $this->smvModel->getLocationActivities($provinceId);

            $progress[$provinceName] = [
                'percentage' => $provinceProgress,
                'cities' => []
            ];

            foreach ($cities as $city) {
                if ($city['province_id'] == $provinceId) {
                    $cityId = $city['id'];
                    $cityName = $city['name'];

                    $cityProgress = $this->smvModel->calculateLocationProgress($cityId);
                    $cityActivities = $this->smvModel->getLocationActivities($cityId);

                    $progress[$provinceName]['cities'][] = [
                        'name' => $cityName,
                        'percentage' => $cityProgress,
                        'activities' => $cityActivities
                    ];
                }
            }
        }

        // Add cities as standalone entries in progress
        foreach ($cities as $city) {
            $cityId = $city['id'];
            $cityName = $city['name'];

            $cityProgress = $this->smvModel->calculateLocationProgress($cityId);
            $cityActivities = $this->smvModel->getLocationActivities($cityId);

            $progress[$cityName] = [
                'percentage' => $cityProgress,
                'cities' => [[
                    'name' => $cityName,
                    'percentage' => $cityProgress,
                    'activities' => $cityActivities
                ]]
            ];
        }

        $data['progress'] = $progress;

        return view('smv/index', $data);
    }

    public function update_status($id)
    {
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks');
        $date_completed = ($status === 'Completed') ? date('Y-m-d') : null;

        $this->smvModel->update($id, [
            'status' => $status,
            'remarks' => $remarks,
            'date_completed' => $date_completed
        ]);

        return redirect()->to('/smv');
    }

    public function summary()
    {
        $data['title'] = 'Summary of Accomplishments';
        $data['summary'] = $this->smvModel->getSummaryData();

        // Prepare chart data before returning the view
        $data['chartData'] = array_map(function ($row) {
            return [
                'label' => $row['name'],
                'value' => $row['percentage']
            ];
        }, $data['summary']);

        return view('smv/summary', $data);
    }

    public function printProgress()
    {
        $location_id = $this->request->getGet('location_id');

        // Get all locations
        $locations = $this->smvModel->getAllLocations();

        // Find the matching location
        $location = array_filter($locations, fn($loc) => $loc['id'] == $location_id);
        $location = reset($location); // get the first match

        $location_name = $location['name'] ?? '—';
        $location_type = $location['type'] ?? '—';

        // Get activities for the location
        $activities = $this->smvModel->getLocationActivities($location_id);

        // Group activities into sections
        $groupedSections = [];
        foreach ($activities as $activity) {
            $sectionTitle = $activity['section'] ?? 'Uncategorized';

            if (!isset($groupedSections[$sectionTitle])) {
                $groupedSections[$sectionTitle] = [
                    'title' => $sectionTitle,
                    'items' => []
                ];
            }

            $groupedSections[$sectionTitle]['items'][] = $activity;
        }

        // Calculate progress
        $percentage = $this->smvModel->calculateLocationProgress($location_id);
        $progress = ['percent' => $percentage];

        return view('rpvara/print_progress', [
            'location_name' => $location_name,
            'location_type' => $location_type,
            'sections' => array_values($groupedSections),
            'progress' => $progress,
            'posting_dates' => $location['posting_date'] ?? null,
            'hearing_dates' => $location['hearing_date'] ?? null
        ]);
    }

}
