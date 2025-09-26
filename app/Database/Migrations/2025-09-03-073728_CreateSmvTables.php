<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSmvTables extends Migration
{
    public function up()
    {
        // 1. smv_categories
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('smv_categories');

        // 2. smv_activities
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'category_id' => ['type' => 'INT'],
            'name' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('category_id', 'smv_categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('smv_activities');

        // 3. smv_progress
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'province_id' => ['type' => 'INT'],
            'municipality_id' => ['type' => 'INT', 'null' => true],
            'activity_id' => ['type' => 'INT'],
            'status' => ['type' => 'ENUM', 'constraint' => ['Completed', 'Not completed'], 'default' => 'Not completed'],
            'date_completed' => ['type' => 'DATE', 'null' => true],
            'remarks' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'on update' => 'CURRENT_TIMESTAMP'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('province_id', 'provinces', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('municipality_id', 'municipalities', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('activity_id', 'smv_activities', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('smv_progress');
    }

    public function down()
    {
        $this->forge->dropTable('smv_progress');
        $this->forge->dropTable('smv_activities');
        $this->forge->dropTable('smv_categories');
    }
}
