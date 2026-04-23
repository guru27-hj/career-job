<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Company;
use App\Models\Category;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $companies = Company::all();
        $categories = Category::all();

        $jobTypes = ['full-time', 'internship', 'contract', 'part-time'];
        $skillsList = [
            ['Laravel', 'PHP', 'MySQL', 'JavaScript'],
            ['React', 'Redux', 'Tailwind', 'API'],
            ['Vue.js', 'Nuxt', 'Node.js', 'MongoDB'],
            ['Python', 'Django', 'PostgreSQL', 'Docker'],
            ['UI/UX', 'Figma', 'Adobe XD', 'User Research'],
            ['WordPress', 'PHP', 'HTML', 'CSS'],
            ['Java', 'Spring Boot', 'Microservices', 'AWS'],
            ['DevOps', 'Kubernetes', 'CI/CD', 'Terraform'],
        ];

        $jobs = [
            ['title' => 'Frontend Developer for growing marketplace', 'slug' => 'frontend-developer', 'description' => 'We are looking for a skilled frontend developer...', 'location' => 'New York', 'remote' => false, 'posted_at' => now()->subDays(3), 'featured' => true, 'min_salary' => 60000, 'max_salary' => 90000, 'job_type' => 'full-time', 'skills' => $skillsList[0]],
            ['title' => 'Senior UX/UI Developer with strong skills', 'slug' => 'senior-ux-ui', 'description' => 'Seeking a creative UX/UI designer...', 'location' => 'Remote', 'remote' => true, 'posted_at' => now()->subDay(), 'featured' => true, 'min_salary' => 80000, 'max_salary' => 120000, 'job_type' => 'full-time', 'skills' => $skillsList[4]],
            ['title' => 'Graphic Designer with WordPress experience', 'slug' => 'graphic-designer', 'description' => 'Design compelling graphics...', 'location' => 'Los Angeles', 'remote' => false, 'posted_at' => now()->subDays(2), 'featured' => true, 'min_salary' => 45000, 'max_salary' => 65000, 'job_type' => 'full-time', 'skills' => $skillsList[5]],
            ['title' => 'Backend Engineer (Laravel)', 'slug' => 'backend-laravel', 'description' => 'Develop robust APIs...', 'location' => 'Remote', 'remote' => true, 'posted_at' => now(), 'featured' => false, 'min_salary' => 70000, 'max_salary' => 100000, 'job_type' => 'full-time', 'skills' => $skillsList[0]],
            ['title' => 'React Developer Intern', 'slug' => 'react-intern', 'description' => 'Learn and build React components...', 'location' => 'San Francisco', 'remote' => false, 'posted_at' => now()->subDays(5), 'featured' => false, 'min_salary' => 20000, 'max_salary' => 30000, 'job_type' => 'internship', 'skills' => $skillsList[1]],
            ['title' => 'DevOps Engineer', 'slug' => 'devops-engineer', 'description' => 'Manage cloud infrastructure...', 'location' => 'Austin', 'remote' => true, 'posted_at' => now()->subDays(4), 'featured' => false, 'min_salary' => 90000, 'max_salary' => 130000, 'job_type' => 'full-time', 'skills' => $skillsList[7]],
            ['title' => 'Java Backend Developer', 'slug' => 'java-backend', 'description' => 'Build scalable systems...', 'location' => 'Chicago', 'remote' => false, 'posted_at' => now()->subDays(6), 'featured' => false, 'min_salary' => 80000, 'max_salary' => 110000, 'job_type' => 'full-time', 'skills' => $skillsList[6]],
        ];

        foreach ($jobs as $jobData) {
            Job::create(array_merge($jobData, [
                'company_id' => $companies->random()->id,
                'category_id' => $categories->random()->id,
            ]));
        }

        // Internships
        $internships = [
            [
                'title' => 'Web Development Intern', 
                'slug' => 'web-development-intern', 
                'description' => 'Learn and build web applications with our team...', 
                'location' => 'Ahmedabad', 
                'remote' => false, 
                'posted_at' => now()->subDays(2), 
                'featured' => true, 
                'min_salary' => 5000, 
                'max_salary' => 10000, 
                'job_type' => 'internship', 
                'skills' => ['HTML', 'CSS', 'JavaScript'], 
                'duration' => '3 Months', 
                'experience_level' => 'Beginner', 
                'certificate_included' => true,
            ],
            [
                'title' => 'Laravel Intern', 
                'slug' => 'laravel-intern', 
                'description' => 'Work on Laravel projects and API development...', 
                'location' => 'Rajkot', 
                'remote' => true, 
                'posted_at' => now()->subDays(1), 
                'featured' => false, 
                'min_salary' => 8000, 
                'max_salary' => 12000, 
                'job_type' => 'internship', 
                'skills' => ['Laravel', 'PHP', 'MySQL'], 
                'duration' => '6 Months', 
                'experience_level' => 'Intermediate', 
                'certificate_included' => true,
            ],
        ];

        foreach ($internships as $internData) {
            Job::create(array_merge($internData, [
                'company_id' => $companies->random()->id,
                'category_id' => $categories->where('name', 'Technology')->first()->id,
            ]));
        }
    }
}
