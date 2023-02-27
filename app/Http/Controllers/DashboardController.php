<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Payment;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // avaialable intervals
        $intervalDays = [
            'day' => 1, // default
            'week' => 7,
            'month' => 30
        ];

        $interval = $request->input('interval', 'day');

        $intervalCondition = fn ($query) =>  $query
            ->where('created_at', '>=', now()->subDays($intervalDays[$interval] ?? 1));

        $assetsReady = Asset::ready()
            ->with('customer:id,name')
            ->where($intervalCondition)
            ->latest('id')
            ->limit(5)
            ->get();

        $assetsInProgress = Asset::inProgress()
            ->with('customer:id,name')
            ->where($intervalCondition)
            ->latest('id')
            ->limit(5)
            ->get();

        // asset count per status, from last (inertval) days
        // TODO: provide defaults for each status when there is no record
        $assetStats = Asset::query()
            ->selectRaw('COUNT(id) as value, status as label')
            ->where($intervalCondition)
            ->whereNot('status', 'returned') // exclude returned
            ->groupBy('status')
            ->get();

        // task count per status, from last (inertval) days
        // TODO: provide defaults for each status when there is no record
        $taskStats = Task::query()
            ->selectRaw('COUNT(id) as value, status as label')
            ->where($intervalCondition)
            ->groupBy('status')
            ->get();

        // get earning stats from last (interval) days
        // with sum of tasks's price as total cost
        // and sum of payments's amount as total payment
        // TODO: find a better way to do this using eloquent
        $earningStats = [
            [
                'label' => 'Total Cost',
                'value' => Task::where($intervalCondition)->sum('price')
            ],
            [
                'label' => 'Total Payment',
                'value' => Payment::where($intervalCondition)->sum('amount')
            ]
        ];

        return inertia('Dashboard', [
            'interval' => $interval,
            // TODO: intervals should contain label with actual value
            'intervals' => array_keys($intervalDays),
            'assetStats' => $assetStats,
            'taskStats' => $taskStats,
            'earningStats' => $earningStats,
            'assetsReady' => $assetsReady,
            'assetsInProgress' => $assetsInProgress,
        ]);
    }
}
