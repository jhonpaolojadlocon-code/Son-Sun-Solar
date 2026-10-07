<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveUsernameFromRegistration extends Migration
{
    public function up(): void
    {
        if ($this->db->fieldExists('Username', 'registration')) {
            $this->forge->dropColumn('registration', 'Username');
        }
    }

    public function down(): void
    {
        if (! $this->db->fieldExists('Username', 'registration')) {
            $this->forge->addColumn('registration', [
                'Username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ],
            ]);
        }
    }
}
