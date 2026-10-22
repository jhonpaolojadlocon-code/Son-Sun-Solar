<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStaffProfileFieldsToAdmin extends Migration
{
    public function up()
    {
        $fields = [
            'FirstName' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'LastName' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'MiddleName' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'Birthday' => ['type' => 'DATE', 'null' => true],
            'Gender' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'PhoneNumber' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'Address' => ['type' => 'TEXT', 'null' => true],
        ];

        $existingFields = array_map('strtolower', $this->db->getFieldNames('admin'));
        foreach ($fields as $field => $definition) {
            if (! in_array(strtolower($field), $existingFields, true)) {
                $this->forge->addColumn('admin', [$field => $definition]);
                $existingFields[] = strtolower($field);
            }
        }
    }

    public function down()
    {
        $fields = ['FirstName', 'LastName', 'MiddleName', 'Birthday', 'Gender', 'PhoneNumber', 'Address'];
        $existingFields = array_map('strtolower', $this->db->getFieldNames('admin'));
        foreach ($fields as $field) {
            if (in_array(strtolower($field), $existingFields, true)) {
                $this->forge->dropColumn('admin', $field);
            }
        }
    }
}
