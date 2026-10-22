<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDepartmentFromRegistration extends Migration
{
    public function up()
    {
        $fields = array_map('strtolower', $this->db->getFieldNames('registration'));

        if (in_array('department', $fields, true)) {
            $this->forge->dropColumn('registration', 'department');
        }
    }

    public function down()
    {
        $fields = array_map('strtolower', $this->db->getFieldNames('registration'));

        if (! in_array('department', $fields, true)) {
            $this->forge->addColumn('registration', [
                'department' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 60,
                    'null'       => true,
                ],
            ]);
        }
    }
}
