<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('company')->where('job_type', 'internship');

        // 🔍 Search by keyword
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // 📍 Location (dropdown)
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // 💰 Stipend range
        $stipendRange = $request->get('stipend_range');
        if ($stipendRange) {
            switch ($stipendRange) {
                case '0-5000':
                    $query->where('max_salary', '<=', 5000);
                    break;
                case '5000-10000':
                    $query->where('min_salary', '>=', 5000)->where('max_salary', '<=', 10000);
                    break;
                case '10000+':
                    $query->where('min_salary', '>=', 10000);
                    break;
            }
        }

        // 🧠 Skills (multiple checkboxes)
        if ($request->filled('skills')) {
            $skills = $request->skills;
            if(!is_array($skills)){
             	$skills = explode(',', $skills); 
            }
            $query->where(function($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhere('skills', 'like', '%"' . trim($skill) . '"%');
                }
            });
        }

        // 📅 Duration
        if ($request->filled('duration')) {
            $query->where('duration', $request->duration);
        }

        // 🎓 Experience Level
        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }

        // 📊 Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'stipend_high':
                $query->orderBy('max_salary', 'desc');
                break;
            case 'best_match':
                // Will sort after adding match percentage
                $query->orderBy('posted_at', 'desc');
                break;
            default:
                $query->orderBy('posted_at', 'desc');
                break;
        }

        // Execute query
        $internships = $query->paginate(10);
        $userSkills = $this->getUserSkills();

        // Calculate match percentage for each internship
        foreach ($internships as $internship) {
            $internship->match_percentage = $this->calculateMatchPercentage($internship->skills, $userSkills);
        }

        // If sorting by best match, reorder the collection
        // Note: Collections sortByDesc works differently than query Builder orderBy
        if ($sort === 'best_match') {
             // To sort the items within the pagination instance:
             $sortedItems = collect($internships->items())->sortByDesc('match_percentage')->values()->all();
             $internships->setCollection(collect($sortedItems));
        }

        $totalInternships = $internships->total();

        // Pass filter values back to view for persisting
        $filters = $request->only(['keyword', 'location', 'stipend_range', 'skills', 'duration', 'experience_level', 'sort']);

        return view('internships.index', compact('internships', 'totalInternships', 'filters'));
    }

    public function show($slug)
    {
        $internship = Job::with('company')
            ->where('slug', $slug)
            ->where('job_type', 'internship')
            ->firstOrFail();

        $userSkills = $this->getUserSkills();
        $internship->match_percentage = $this->calculateMatchPercentage($internship->skills, $userSkills);

        // Similar internships (same category or common skills)
        $similar = Job::where('job_type', 'internship')
            ->where('id', '!=', $internship->id)
            ->where(function($q) use ($internship) {
                // Wrap in where to group OR clauses correctly
                $q->where('category_id', $internship->category_id);
                if (!empty($internship->skills)) {
                    $firstSkill = is_array($internship->skills) ? $internship->skills[0] : json_decode($internship->skills)[0] ?? '';
                    if ($firstSkill) {
                        $q->orWhereJsonContains('skills', $firstSkill);
                    }
                }
            })
            ->limit(4)
            ->get();

        foreach ($similar as $sim) {
            $sim->match_percentage = $this->calculateMatchPercentage($sim->skills, $userSkills);
        }

        return view('internships.show', compact('internship', 'similar'));
    }

    // Helper: get user's skills (from session or database)
    private function getUserSkills()
    {
        // For demo, we store skills in session. In production, fetch from user profile.
        return session('user_skills', ['HTML', 'CSS', 'Laravel']);
    }

    // Helper: calculate match percentage based on skill overlap
    private function calculateMatchPercentage($jobSkills, $userSkills)
    {
        if (empty($jobSkills) || empty($userSkills)) return 0;
        $jobSkills = is_array($jobSkills) ? $jobSkills : json_decode($jobSkills, true);
        
        if (!is_array($jobSkills)) return 0;
        
        $common = array_intersect($jobSkills, $userSkills);
        return round((count($common) / count($jobSkills)) * 100);
    }
}
