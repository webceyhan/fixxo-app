<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $assetsReady = Asset::ready()
            ->with('customer:id,name')
            ->latest()
            ->limit(5)
            ->get();

        $assetsInProgress = Asset::inProgress()
            ->with('customer:id,name')
            ->latest()
            ->limit(5)
            ->get();


        return inertia('Dashboard', [
            'assetsReady' => $assetsReady,
            'assetsInProgress' => $assetsInProgress,
        ]);
    }
}
