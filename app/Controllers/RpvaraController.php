<?php

namespace App\Controllers;

use App\Models\RpvaraModel;

class RpvaraController extends BaseController
{
    public function progress()
    {
        $model = new RpvaraModel();
        $locations = $model->getLocations();

        // Get location ID from query or default to first available
        $locationId = $this->request->getGet('location_id');
        if (!$locationId && !empty($locations)) {
            $locationId = $locations[0]['id'];
        }

        // Default values
        $location_name = '—';
        $posting_dates = null;
        $hearing_dates = null;
        $activities = [];
        $sections = [];
        $progress = ['done' => 0, 'total' => 0, 'percent' => 0];

        // Fetch location details
        $loc = array_filter($locations, fn($l) => $l['id'] == $locationId);
        $loc = reset($loc);

        if ($loc) {
            $location_name = $loc['name'] ?? '—';
            $posting_dates = $loc['posting_date'] ?? null;
            $hearing_dates = $loc['hearing_date'] ?? null;

            // Fetch activities and progress
            $activities = $model->getActivitiesByLocation($locationId);
            $progress = $model->getProgress($locationId);

            // Group activities by category
            foreach ($activities as $activity) {
                $catId = $activity['category_id'];
                if (!isset($sections[$catId])) {
                    $sections[$catId] = [
                        'title' => $activity['category_name'],
                        'items' => []
                    ];
                }
                $sections[$catId]['items'][] = $activity;
            }

            ksort($sections);
        }

        return view('rpvara/progress', [
            'locations'         => $locations,
            'location_id'       => $locationId,
            'location_name'     => $location_name,
            'posting_dates'     => $posting_dates,
            'hearing_dates'     => $hearing_dates,
            'progress'          => $progress,
            'sections'          => $sections
        ]);
    }
}
