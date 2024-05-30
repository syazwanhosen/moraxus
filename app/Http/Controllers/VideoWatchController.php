<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoWatch;
use App\Models\User;

class VideoWatchController extends Controller
{
    public function index($organization_id)
    {
        // Query to find file$videoWatch with the specified organization_id and role 'user'
        $videoWatchs = VideoWatch::where('organization_id', $organization_id)
                        ->get();

        // Initialize an array to hold the responses for each month
        $monthlyResponses = [];
        
        // Loop through each file download and group them by month
        foreach ($videoWatchs as $videoWatch) {
            
            // If the month key doesn't exist in the array, create it
            if (!isset($monthlyResponses)) {
                $monthlyResponses = [];
            }
            
            // Add the file download data to the respective month array
            $monthlyResponses[] = $videoWatch;
        }
        
        // Return the result as a JSON response
        return response()->json($monthlyResponses);
    }

    public function store(Request $request)
    {
        $videoWatch = new VideoWatch();
        $user = User::findOrFail($request->user_id);

        if (!$user) {
            // Handle case where user is not found
            return response()->json(['message' => 'User not found'], 404);
        }

         // Update user data
         if($user->stage_completed < $request->stage) {
            $user->stage_completed = $request->stage;
            $user->save();
         }
         
        $videoWatch->organization_id = $request->organization_id;
        $videoWatch->save();

        return response()->json(['message' => 'Video Watch is successfully added'], 201);
    }
}
