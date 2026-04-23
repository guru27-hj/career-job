<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'TechCorp',
            'slug' => 'techcorp',
            'logo' => 'company-logos/techcorp.png', // placeholder
            'banner' => 'company-banners/techcorp-banner.jpg',
            'description' => 'We build amazing software...',
            'industry' => 'Information Technology',
            'location' => 'San Francisco, CA',
            'headquarters' => 'New York, NY',
            'employees' => 500,
            'founded_year' => 2010,
            'website' => 'https://techcorp.com',
            'email' => 'careers@techcorp.com',
            'phone' => '+1-555-123-4567',
            'social_links' => json_encode(['linkedin' => 'https://linkedin.com/company/techcorp', 'twitter' => 'https://twitter.com/techcorp']),
            'status' => 'approved',
        ]);
        // Add more...
    }
}
