<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyFollowController extends Controller
{
    /**
     * Toggle follow / unfollow for the authenticated user.
     * Responds with JSON for AJAX calls, redirects for normal requests.
     */
    public function toggle(Request $request, Company $company)
    {
        $user = $request->user();

        // Toggle using syncWithoutDetaching + detach pattern
        if ($user->follows($company->id)) {
            // Already following → unfollow
            $user->followedCompanies()->detach($company->id);
            $following  = false;
            $message    = "You unfollowed {$company->name}.";
        } else {
            // Not following → follow
            $user->followedCompanies()->attach($company->id, [
                'followed_at' => now(),
            ]);
            $following  = true;
            $message    = "You are now following {$company->name}!";
        }

        $followerCount = $company->followers()->count();

        // AJAX response
        if ($request->expectsJson()) {
            return response()->json([
                'following'      => $following,
                'message'        => $message,
                'follower_count' => $followerCount,
            ]);
        }

        // Standard form redirect
        return back()->with('success', $message);
    }
}
