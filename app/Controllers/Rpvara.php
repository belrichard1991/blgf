<?php

namespace App\Controllers;

use App\Models\RpvaraModel;
use CodeIgniter\Controller;

class Rpvara extends Controller
{
    protected $rpvaraModel;

    public function __construct()
    {
        $this->rpvaraModel = new RpvaraModel();
    }

   public function progress($location_id = null)
    {
        $locationModel = new \App\Models\LocationModel();
        $locations = $locationModel->findAll();

        $location_id = $this->request->getGet('location_id') ?? $location_id;

        if (!$location_id && !empty($locations)) {
            $location_id = $locations[0]['id'];
        }

        $location = $locationModel->find($location_id);
        $location_name = $location['name'] ?? '—';
        $posting_dates = $location['posting_date'] ?? null;
        $hearing_dates = $location['hearing_date'] ?? null;

        $activities = $this->rpvaraModel->getActivitiesByLocation($location_id);
        $overall_percentage = $this->rpvaraModel->calculateProgress($location_id);

        $sections = [];
        foreach ($activities as $activity) {
            $cat_id = $activity['category_id'];
            if (!isset($sections[$cat_id])) {
                $sections[$cat_id] = [
                    'title' => $activity['category_name'],
                    'items' => []
                ];
            }
            $sections[$cat_id]['items'][] = [
                'id' => $activity['id'],
                'activity' => $activity['activity_name'],
                'status' => $activity['status'],
                'date_completed' => $activity['date_completed'],
                'remarks' => $activity['remarks'],
            ];
        }

        ksort($sections);

        return view('rpvara/progress', [
            'location_id'         => $location_id,
            'location_name'       => $location_name,
            'posting_dates'       => $posting_dates,
            'hearing_dates'       => $hearing_dates,
            'sections'            => $sections,
            'overall_percentage'  => $overall_percentage,
            'locations'           => $locations
        ]);
    }



    public function update($id)
    {
        $data = [
            'status' => $this->request->getPost('status'),
            'date_completed' => $this->request->getPost('date_completed') ?: null,
            'remarks' => $this->request->getPost('remarks')
        ];

        $this->rpvaraModel->update($id, $data);
        return redirect()->back()->with('message', 'Activity updated successfully!');
    }

    public function printProgress()
    {
        $locationModel = new \App\Models\LocationModel();

        $location_id = $this->request->getGet('location_id');
        $location = $locationModel->find($location_id);
        $location_name = $location['name'] ?? '—';
        $posting_dates = $location['posting_date'] ?? null;
        $hearing_dates = $location['hearing_date'] ?? null;

        $activities = $this->rpvaraModel->getActivitiesByLocation($location_id);
        $overall_percentage = $this->rpvaraModel->calculateProgress($location_id);

        $sections = [];
        foreach ($activities as $activity) {
            $cat_id = $activity['category_id'];
            if (!isset($sections[$cat_id])) {
                $sections[$cat_id] = [
                    'title' => $activity['category_name'],
                    'items' => []
                ];
            }
            $sections[$cat_id]['items'][] = [
                'activity' => $activity['activity_name'],
                'status' => $activity['status'],
                'date_completed' => $activity['date_completed'],
                'remarks' => $activity['remarks'],
            ];
        }

        ksort($sections);

        return view('rpvara/print_progress', [
            'location_name'      => $location_name,
            'posting_dates'      => $posting_dates,
            'hearing_dates'      => $hearing_dates,
            'sections'           => $sections,
            'overall_percentage' => $overall_percentage
        ]);
    }


}
