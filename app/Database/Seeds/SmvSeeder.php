<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SmvSeeder extends Seeder
{
    public function run()
    {
        // Insert Categories
        $categories = [
            ['name' => 'Preparatory'],
            ['name' => 'Data Collection'],
            ['name' => 'Data Analysis'],
            ['name' => 'Preparation of Proposed SMV'],
            ['name' => 'Valuation Testing'],
        ];

        $this->db->table('smv_categories')->insertBatch($categories);

        // Insert Activities
        $activities = [
            // Preparatory
            ['category_id' => 1, 'name' => 'Set the date of valuation'],
            ['category_id' => 1, 'name' => 'Prepare work plan'],
            ['category_id' => 1, 'name' => 'Prepare budget proposal'],
            ['category_id' => 1, 'name' => 'Create and organize SMV teams / TWG'],

            // Data Collection
            ['category_id' => 2, 'name' => 'Identify market areas'],
            ['category_id' => 2, 'name' => 'Establish a database/inventory'],
            ['category_id' => 2, 'name' => 'Examine transaction database/inventory'],
            ['category_id' => 2, 'name' => 'Review sales prior to inspection'],
            ['category_id' => 2, 'name' => 'Investigate the property'],
            ['category_id' => 2, 'name' => 'Collect, validate, and filter data'],

            // Data Analysis
            ['category_id' => 3, 'name' => 'Review/Amend existing sub-market areas'],
            ['category_id' => 3, 'name' => 'Analyze transaction data'],
            ['category_id' => 3, 'name' => 'Process analyzed data'],

            // Preparation of Proposed SMV
            ['category_id' => 4, 'name' => 'Set interval or value ranges'],
            ['category_id' => 4, 'name' => 'Craft the working land value map'],
            ['category_id' => 4, 'name' => 'Testing the developed SMV'],
            ['category_id' => 4, 'name' => 'Check values of adjoining LGUs'],

            // Valuation Testing
            ['category_id' => 5, 'name' => 'Finalization of Proposed SMV'],
        ];

        $this->db->table('smv_activities')->insertBatch($activities);
    }
}
