<?php

namespace App\Http\Controllers;

use App\Enums\Interval;
use App\Models\Asset;
use App\Models\Customer;
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

        // ------------------------------------------------------
        // TODO: put this query somewhere else!
        // get mysql date function based on the given interval
        $fx = [
            Interval::DAY => 'hour',
            Interval::WEEK => 'day',
            Interval::MONTH => 'week',
        ][$interval];

        $incomes = Task::query()
            ->since($interval)
            ->selectRaw($fx . '(created_at) AS date')
            ->selectRaw('SUM(price) AS price')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ------------------------------------------------------

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

        $assetsUnpaid = Asset::unpaid()
            ->with('customer:id,name')
            ->since($interval)
            ->latest('id')
            ->limit(5)
            ->get()
            ->append('balance');

        // asset count per status, from last (inertval) days
        // TODO: provide defaults for each status when there is no record
        $assetStats = Asset::stats()->since($interval)->get();

        // task count per status, from last (inertval) days
        // TODO: provide defaults for each status when there is no record
        $taskStats = Task::stats()->since($interval)->get();

        // get earning stats from last (interval) days
        // with sum of tasks's price as total cost
        // and sum of payments's amount as total payment
        // TODO: find a better way to do this using eloquent
        $earningStats = [
            [
                'label' => 'expected',
                'value' => Task::since($interval)->sum('price')
            ],
            [
                'label' => 'received',
                'value' => Payment::since($interval)->sum('amount')
            ]
        ];

        return inertia('Dashboard/Index', [
            'interval' => $interval,
            'intervalOptions' => $intervalOptions,
            'incomes' => $incomes,
            'assetStats' => $assetStats,
            'taskStats' => $taskStats,
            'earningStats' => $earningStats,
            'assetsReady' => $assetsReady,
            'assetsInProgress' => $assetsInProgress,
            'assetsUnpaid' => $assetsUnpaid,
            //
            'totalCustomers' => Customer::since($interval)->count(),
            'totalAssets' => Asset::since($interval)->count(),
            'totalTasks' => Task::since($interval)->count(),
            'totalPayments' => Payment::since($interval)->count(),
        ]);
    }
}
