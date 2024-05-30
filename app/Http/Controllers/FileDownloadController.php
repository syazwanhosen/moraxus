<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileDownload;


class FileDownloadController extends Controller
{

    public function index($organization_id)
    {
        // Query to find file$fileDownload with the specified organization_id and role 'user'
        $fileDownloads = FileDownload::where('organization_id', $organization_id)
                        ->get();
        
        // Initialize an array to hold the responses for each month
        $monthlyResponses = [];
        
        // Loop through each file download and group them by month
        foreach ($fileDownloads as $fileDownload) {
            
            // If the month key doesn't exist in the array, create it
            if (!isset($monthlyResponses)) {
                $monthlyResponses = [];
            }
            
            // Add the file download data to the respective month array
            $monthlyResponses[] = $fileDownload;
        }
        
        // Return the result as a JSON response
        return response()->json($monthlyResponses);
    }
    

    public function store(Request $request)
    {
        $fileDownload = new FileDownload();

        $fileDownload->organization_id = $request->organization_id;
        $fileDownload->save();

        return response()->json(['message' => 'File Download is successfully added'], 201);
    }

}
