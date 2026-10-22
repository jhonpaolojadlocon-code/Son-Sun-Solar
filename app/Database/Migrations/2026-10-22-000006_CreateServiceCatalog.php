<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServiceCatalog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'service_name' => ['type' => 'VARCHAR', 'constraint' => 80],
            'price' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'available' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('service_name');
        $this->forge->createTable('service_catalog', true);

        foreach (['Consultation', 'Designing', 'Permitting', 'Installation', 'Maintenance', 'Repair', 'Monitoring'] as $service) {
            $this->db->table('service_catalog')->ignore(true)->insert(['service_name' => $service, 'available' => 1]);
        }
    }

    public function down()
    {
        $this->forge->dropTable('service_catalog', true);
    }
}
