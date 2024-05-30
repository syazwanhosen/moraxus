<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function index($organization_id)
    {
        $feedback = Feedback::where('organization_id', $organization_id)->get();

        return response()->json($feedback);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'description' => 'required|string',
        ]);

        // Create a new feedback instance
        $feedback = new Feedback();
        $feedback->description = $request->description;
        // Assuming authenticated user's ID is used as 'created_by'
        $feedback->created_by = $request->name;
        $feedback->organization_id = $request->organization_id;
        $feedback->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }
}

