<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index($organization_id)
    {
        // Query to find users with the specified organization_id and role 'user'
        $users = User::where('organization_id', $organization_id)
                    ->where('roles', 'user')
                    ->get();
        
        // Return the result as a JSON response
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create and save the user
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'roles' => 'user',
            'organization_id' => $request->organization_id,
            'stage_completed' => '0'
        ]);

        return redirect()->back()->with('success', 'Employee submitted successfully!');

    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update user data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Return response
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function show($id) {
          // Retrieve the user record by ID
          $user = User::find($id);

          if (!$user) {
              // Handle case where user is not found
              return response()->json(['message' => 'User not found'], 404);
          }
  
          // Return the user record
          return response()->json($user);
    }

    public function destroy($id)
    {
        // Find the resource by ID
        $employee = User::findOrFail($id);

        // Delete the resource
        $employee->delete();

        // Return a response
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
