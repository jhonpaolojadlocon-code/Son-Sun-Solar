<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmployeeDetailsToRegistration extends Migration
{
    public function up()
    {
        $fields = [
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'middle_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'birthday' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'gender' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'phone_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'department' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
        ];

        $existingFields = array_map('strtolower', $this->db->getFieldNames('registration'));
        foreach ($fields as $field => $definition) {
            if (! in_array(strtolower($field), $existingFields, true)) {
                $this->forge->addColumn('registration', [$field => $definition]);
                $existingFields[] = strtolower($field);
            }
        }
    }

    public function down()
    {
        $fields = [
            'first_name',
            'last_name',
            'middle_name',
            'birthday',
            'gender',
            'phone_number',
            'address',
            'department',
        ];

        $existingFields = array_map('strtolower', $this->db->getFieldNames('registration'));
        foreach ($fields as $field) {
            if (in_array(strtolower($field), $existingFields, true)) {
                $this->forge->dropColumn('registration', $field);
            }
        }
    }
}
