<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutSection;

class AboutSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'Connecting Talent with Opportunity',
                'content' => [
                    'subtitle' => 'The premier job and internship platform for discovering your true potential.',
                    'button_text' => 'Explore Jobs',
                    'button_link' => '/jobs',
                ],
            ],
            [
                'section_key' => 'story',
                'title' => 'About Our Platform',
                'content' => [
                    'text' => 'We realized that students struggle to find relevant internships while top companies struggle to discover verified, eager talent. That is why we built CareerConnect—a bridge between ambitious individuals and incredible organizations.',
                ],
            ],
            [
                'section_key' => 'mission_vision',
                'title' => 'Mission & Vision',
                'content' => [
                    'mission_text' => 'Empower students with the right opportunities by providing a reliable, user-friendly platform that removes barriers to career entry.',
                    'vision_text' => 'Become the #1 career platform for college students globally, fostering a seamless transition from education to employment.',
                ],
            ],
            [
                'section_key' => 'stats',
                'title' => 'Our Achievements',
                'content' => [
                    'students' => 10000,
                    'companies' => 500,
                    'jobs' => 2000,
                    'internships' => 1200,
                ],
            ],
            [
                'section_key' => 'team',
                'title' => 'Meet the Team',
                'content' => [
                    'members' => [
                        [
                            'name' => 'John Doe',
                            'role' => 'Founder & CEO',
                            'photo' => '',
                            'linkedin' => '#'
                        ],
                        [
                            'name' => 'Jane Smith',
                            'role' => 'Head of Partnerships',
                            'photo' => '',
                            'linkedin' => '#'
                        ],
                        [
                            'name' => 'Mike Johnson',
                            'role' => 'Lead Engineer',
                            'photo' => '',
                            'linkedin' => '#'
                        ],
                    ]
                ],
            ],
            [
                'section_key' => 'features',
                'title' => 'Why Choose Us',
                'content' => [
                    'points' => [
                        ['title' => 'Smart job matching', 'icon' => 'fas fa-brain'],
                        ['title' => 'Easy apply system', 'icon' => 'fas fa-paper-plane'],
                        ['title' => 'Verified companies', 'icon' => 'fas fa-check-circle'],
                        ['title' => 'Internship focus', 'icon' => 'fas fa-graduation-cap'],
                    ]
                ],
            ],
            [
                'section_key' => 'cta',
                'title' => 'Start your career journey today',
                'content' => [
                    'register_text' => 'Register Now',
                    'register_link' => '/register',
                    'browse_text' => 'Browse Jobs',
                    'browse_link' => '/jobs',
                ],
            ],
        ];

        foreach ($sections as $section) {
            AboutSection::updateOrCreate(
                ['section_key' => $section['section_key']],
                $section
            );
        }
    }
}
