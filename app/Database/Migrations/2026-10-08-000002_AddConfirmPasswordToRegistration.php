<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddConfirmPasswordToRegistration extends Migration
{
    public function up(): void
    {
        // Password confirmation is validated during registration and is not stored.
    }

    public function down(): void
    {
        // No schema changes are made by this migration.
    }
}
