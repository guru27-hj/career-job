<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'icon' => 'fa-laptop-code'],
            ['name' => 'Design', 'slug' => 'design', 'icon' => 'fa-palette'],
            ['name' => 'Marketing', 'slug' => 'marketing', 'icon' => 'fa-chart-line'],
            ['name' => 'Customer Support', 'slug' => 'customer-support', 'icon' => 'fa-headset'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
