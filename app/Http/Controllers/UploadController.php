<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $assetId = $request->input('asset_id');
        $images = $request->file('images', []);

        UploadService::putAll($images, $assetId);

        // redirect back with success message
        return back()->with('status', 'Images uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        //
    }
}
