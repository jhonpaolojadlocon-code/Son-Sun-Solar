<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveConfirmPasswordFromRegistration extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('registration');

        foreach ($fields as $field) {
            if (in_array(strtolower(str_replace('_', '', $field)), ['confirmpassword'], true)) {
                $this->forge->dropColumn('registration', $field);
            }
        }
    }

    public function down()
    {
        $fields = array_map(static fn ($field) => strtolower(str_replace('_', '', $field)), $this->db->getFieldNames('registration'));

        if (! in_array('confirmpassword', $fields, true)) {
            $this->forge->addColumn('registration', [
                'confirmpassword' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ]);
        }
    }
}
