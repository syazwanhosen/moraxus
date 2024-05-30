<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modules;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    public function index($organization_id)
    {
        $modules = modules::where('organization_id', $organization_id)->get();

        return response()->json($modules);
    }

    public function store(Request $request)
    {

        $request->validate([
            'file' => 'max:20480',
            'video' => 'mimes:mp4,mov,ogg,qt|max:20000',
            'moduleName' => 'required|string|max:255',
            'description' => 'required|string',
            'stage' => 'required|string',
        ]);

        $fileDocument = $request->file('file');
        $fileVideo = $request->file('video');


        $module = new modules();

        if ($fileDocument) {
            $pathDocument = $fileDocument->store('public');
            $module->file_name = $fileDocument->getClientOriginalName();
            $module->file_path = $pathDocument;
            $module->file_type = $fileDocument->getClientOriginalExtension();
        }
        

        if ($fileVideo) {
            $pathVideo = $fileVideo->store('public');
            $module->video_name = $fileVideo->getClientOriginalName();
            $module->video_path = $pathVideo;
            $module->video_type = $fileVideo->getClientOriginalExtension();
        }
        

        $module->module_name = $request->moduleName;
        $module->description = $request->description;
        $module->stage = $request->stage;
        $module->organization_id = $request->organization_id;
        $module->save();

        return response()->json(['message' => 'Module is successfully added'], 201);
    }

    public function update(Request $request)
    {

        // Validate the request data
        $request->validate([
            'moduleName' => 'string|max:255',
            'description' => 'string|max:255',
            'stage' => 'string|max:255',
        ]);


        // Find the module by ID
        $module = modules::findOrFail($request->id);
        
        $fileDocument = $request->file('file');
        $fileVideo = $request->file('video');

        if($fileDocument) {
            $pathDocument = $fileDocument->store('public');
            if($fileDocument) {
                Storage::delete($module->file_path);
            }
            $module->file_name = $fileDocument->getClientOriginalName();
            $module->file_path = $pathDocument;
            $module->file_type = $fileDocument->getClientOriginalExtension();
        }
        
        if($fileVideo) {
            $pathVideo = $fileVideo->store('public');
            if($module->video_path) {
                Storage::delete($module->video_path);
            }
            $module->video_name = $fileVideo->getClientOriginalName();
            $module->video_path = $pathVideo;
            $module->video_type = $fileVideo->getClientOriginalExtension();
        }

        $module->module_name = $request->moduleName;
        $module->description = $request->description;
        $module->stage = $request->stage;
        $module->save();

        // Return response
        return response()->json(['message' => 'module updated successfully', 'module' => $module]);
    }

    public function showModuleByOrganizationId($organization_id) {

        $module = modules::where('organization_id', $organization_id)->first();

          if (!$module) {
              // Handle case where module is not found
              return response()->json(['message' => 'module not found'], 404);
          }
  
          // Return the module record
          return response()->json($module);
    }

    public function showModuleByStage($organization_id, $stage) {

        $module = modules::where('organization_id', $organization_id)
                    ->where('stage', $stage)
                    ->first();

          if (!$module) {
              // Handle case where module is not found
              return response()->json(['message' => 'module not found'], 404);
          }
  
          // Return the module record
          return response()->json($module);
    }



    public function show($id) {

        $module = modules::findOrFail($id);

          if (!$module) {
              // Handle case where module is not found
              return response()->json(['message' => 'module not found'], 404);
          }
  
          // Return the module record
          return response()->json($module);
    }

    public function destroy($id)
    {
        // Find the resource by ID
        $module = modules::findOrFail($id);

        if($module->file_path) {
            Storage::delete($module->file_path);
        }

        if($module->video_path) {
            Storage::delete($module->video_path);
        }

        // Delete the resource
        $module->delete();

        // Return a response
        return response()->json(['message' => 'Module deleted successfully']);
    }
    
    public function download($file)
    {
        $filePath = storage_path('app/public/' . $file); // Adjust the path as needed

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($filePath);
    }
}
