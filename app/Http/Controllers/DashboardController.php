<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Feedback;
use App\Models\modules;

class DashboardController extends Controller
{
    public function show($organization_id) {
        $feedbacks_count = Feedback::where('organization_id', $organization_id)->count();
        $users_count = User::where('organization_id', $organization_id)
                    ->where('roles', 'user')
                    ->count();
     
        $documents_count = modules::where('organization_id', $organization_id)
                            ->whereNotNull('file_name')
                            ->count();
     
        $videos_count = modules::where('organization_id', $organization_id)
                            ->whereNotNull('video_name')
                            ->count();

        return response()->json(['feedbacks_count' => $feedbacks_count, 'users_count' => $users_count, 'documents_count' => $documents_count, 'videos_count' => $videos_count]);

    }

    public function employeeProgress($organization_id) {
        $users = User::where('organization_id', $organization_id)
                    ->where('roles', 'user')
                    ->get();

        $modules = modules::where('organization_id', $organization_id)->count();

        return response()->json(['data' => $users, 'modules' => $modules]);
        
    }
}
