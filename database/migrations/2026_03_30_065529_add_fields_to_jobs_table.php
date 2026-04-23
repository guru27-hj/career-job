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
            $table->integer('min_salary')->nullable()->after('salary_range');
            $table->integer('max_salary')->nullable()->after('min_salary');
            $table->string('job_type')->default('full-time')->after('remote'); // full-time, internship, contract
            $table->json('skills')->nullable()->after('job_type'); // store array of skills
            // Remove old salary_range if you want to use separate fields
            // $table->dropColumn('salary_range');
        });
    }

    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['min_salary', 'max_salary', 'job_type', 'skills']);
            // $table->string('salary_range')->nullable();
        });
    }
};
