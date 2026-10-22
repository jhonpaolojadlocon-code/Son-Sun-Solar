<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClientServiceFeatures extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customer_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'service_type' => ['type' => 'VARCHAR', 'constraint' => 80],
            'scheduled_for' => ['type' => 'DATETIME'],
            'address' => ['type' => 'TEXT'],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'Pending'],
            'assigned_employee' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('customer_id');
        $this->forge->addKey('assigned_employee');
        $this->forge->createTable('service_bookings', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 160],
            'message' => ['type' => 'TEXT'],
            'audience' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'employees'],
            'created_by' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('announcements', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'booking_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'employee_email' => ['type' => 'VARCHAR', 'constraint' => 255],
            'details' => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('booking_id');
        $this->forge->addKey('employee_email');
        $this->forge->createTable('service_reports', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customer_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'subject' => ['type' => 'VARCHAR', 'constraint' => 160],
            'message' => ['type' => 'TEXT'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'Open'],
            'created_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('customer_id');
        $this->forge->createTable('support_tickets', true);

        $attendanceFields = array_map('strtolower', $this->db->getFieldNames('employee_attendance'));
        foreach ([
            'employee_name' => ['type' => 'VARCHAR', 'constraint' => 201, 'null' => true],
            'latitude' => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'longitude' => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
        ] as $field => $definition) {
            if (! in_array(strtolower($field), $attendanceFields, true)) {
                $this->forge->addColumn('employee_attendance', [$field => $definition]);
            }
        }

        $adminFields = array_map('strtolower', $this->db->getFieldNames('admin'));
        if (! in_array('isactive', $adminFields, true)) {
            $this->forge->addColumn('admin', ['IsActive' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1]]);
        }
    }

    public function down()
    {
        $this->forge->dropTable('service_reports', true);
        $this->forge->dropTable('support_tickets', true);
        $this->forge->dropTable('announcements', true);
        $this->forge->dropTable('service_bookings', true);
        foreach (['employee_name', 'latitude', 'longitude'] as $field) {
            $fields = array_map('strtolower', $this->db->getFieldNames('employee_attendance'));
            if (in_array($field, $fields, true)) {
                $this->forge->dropColumn('employee_attendance', $field);
            }
        }
        $adminFields = array_map('strtolower', $this->db->getFieldNames('admin'));
        if (in_array('isactive', $adminFields, true)) {
            $this->forge->dropColumn('admin', 'IsActive');
        }
    }
}
