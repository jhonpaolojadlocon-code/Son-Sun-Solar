<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddConfirmPasswordToRegistration extends Migration
{
    public function up(): void
    {
        if (! $this->db->fieldExists('confirmpassword', 'registration')) {
            $this->forge->addColumn('registration', [
                'confirmpassword' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ]);
        }
    }

    public function down(): void
    {
        if ($this->db->fieldExists('confirmpassword', 'registration')) {
            $this->forge->dropColumn('registration', 'confirmpassword');
        }
    }
}
