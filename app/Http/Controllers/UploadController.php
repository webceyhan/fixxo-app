<?php

namespace App\Http\Controllers;

use App\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $folder = $request->input('folder');
        $images = $request->file('images', []);

        UploadService::putAll($images, $folder);

        // redirect back with success message
        return back()->with('status', 'Images uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $url = $request->input('url');

        UploadService::delete($url);

        // redirect back with success message
        return back()->with('status', 'Image deleted successfully.');
    }
}
