<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'website_id' => 'required|exists:websites,id',
        ]);

        $user = Auth::user();
        $websiteId = $request->input('website_id');

        // Check if the user has already voted before
        $existingVote = Vote::where('user_id', $user->id)
                            ->where('website_id', $websiteId)
                            ->first();

        if ($existingVote) {
            return response()->json(['message' => 'You have already voted for this website.'], 400);
        }

        // Create a new vote
        Vote::create([
            'user_id' => $user->id,
            'website_id' => $websiteId,
        ]);

        return response()->json(['message' => 'Vote recorded successfully.']);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        // Find the vote by user and website ID
        $vote = Vote::where('user_id', $user->id)
                    ->where('id', $id)
                    ->first();

        if (!$vote) {
            return response()->json(['message' => 'Vote not found.'], 404);
        }

        $vote->delete();

        return response()->json(['message' => 'Vote removed successfully.']);
    }
}
