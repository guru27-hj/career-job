<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('duration')->nullable()->after('job_type');
            $table->string('experience_level')->nullable()->after('duration');
            $table->boolean('certificate_included')->default(false)->after('experience_level');
        });
    }

    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['duration', 'experience_level', 'certificate_included']);
        });
    }
};
