<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL requires dropping & recreating enum to change values.
        // Step 1: temporarily use string so no data is lost
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'pending'");

        // Step 2: rename existing 'selected' rows → 'shortlisted'
        DB::statement("UPDATE job_applications SET status = 'shortlisted' WHERE status = 'selected'");

        // Step 3: apply the new enum
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending','shortlisted','hired','rejected') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'pending'");
        DB::statement("UPDATE job_applications SET status = 'selected' WHERE status = 'shortlisted'");
        DB::statement("UPDATE job_applications SET status = 'pending'  WHERE status = 'hired'");
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending','selected','rejected') NOT NULL DEFAULT 'pending'");
    }
};
