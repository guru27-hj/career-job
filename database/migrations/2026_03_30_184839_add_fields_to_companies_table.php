<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name')->nullable();
            $table->string('banner')->nullable()->after('logo');
            $table->text('description')->nullable();
            $table->string('industry')->nullable();
            $table->string('headquarters')->nullable();
            $table->integer('employees')->nullable();
            $table->integer('founded_year')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->json('social_links')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['slug', 'banner', 'description', 'industry', 'headquarters', 'employees', 'founded_year', 'email', 'phone', 'social_links', 'status']);
        });
    }
};
