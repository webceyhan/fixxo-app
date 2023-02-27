<?php

namespace App\Http\Controllers;

use App\Enums\Interval;
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
        $intervalOptions = [
            Interval::DAY => 'Today',
            Interval::WEEK => 'This Week',
            Interval::MONTH => 'This Month',
        ];

        $interval = $request->input('interval', Interval::DAY);

        $assetsReady = Asset::ready()
            ->with('customer:id,name')
            ->since($interval)
            ->latest('id')
            ->limit(5)
            ->get();

        $assetsInProgress = Asset::inProgress()
            ->with('customer:id,name')
            ->since($interval)
            ->latest('id')
            ->limit(5)
            ->get();

        // asset count per status, from last (inertval) days
        // TODO: provide defaults for each status when there is no record
        $assetStats = Asset::query()
            ->selectRaw('COUNT(id) as value, status as label')
            ->since($interval)
            ->whereNot('status', 'returned') // exclude returned
            ->groupBy('status')
            ->get();

        // task count per status, from last (inertval) days
        // TODO: provide defaults for each status when there is no record
        $taskStats = Task::query()
            ->selectRaw('COUNT(id) as value, status as label')
            ->since($interval)
            ->groupBy('status')
            ->get();

        // get earning stats from last (interval) days
        // with sum of tasks's price as total cost
        // and sum of payments's amount as total payment
        // TODO: find a better way to do this using eloquent
        $earningStats = [
            [
                'label' => 'Total Cost',
                'value' => Task::since($interval)->sum('price')
            ],
            [
                'label' => 'Total Payment',
                'value' => Payment::since($interval)->sum('amount')
            ]
        ];

        return inertia('Dashboard', [
            'interval' => $interval,
            'intervalOptions' => $intervalOptions,
            'assetStats' => $assetStats,
            'taskStats' => $taskStats,
            'earningStats' => $earningStats,
            'assetsReady' => $assetsReady,
            'assetsInProgress' => $assetsInProgress,
        ]);
    }
}
