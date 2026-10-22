<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeeAttendance extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'employee_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'work_date' => [
                'type' => 'DATE',
            ],
            'time_in' => [
                'type' => 'DATETIME',
            ],
            'time_out' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['employee_email', 'work_date'], true);
        $this->forge->createTable('employee_attendance', true);
    }

    public function down()
    {
        $this->forge->dropTable('employee_attendance', true);
    }
}
