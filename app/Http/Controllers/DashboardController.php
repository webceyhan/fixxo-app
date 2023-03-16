<?php

namespace App\Http\Controllers;

use App\Enums\Interval;
use App\Models\Asset;
use App\Models\Payment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $assetsUnpaid = $this->getUnpaidAssets()
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
            'assetsUnpaid' => $assetsUnpaid,
        ]);
    }

    /**
     * Get all assets with their cost (sum of its tasks) and paid amount (sum of its payments) 
     * ordered by their balance which is the difference between cost and paid amount.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function getUnpaidAssets()
    {
        // todo: make this calculations on the model level using precalculated attributes 
        // and fetch using scope variables to build different queries
        return Asset::returned()
            ->select(
                'assets.*',
                DB::raw('COALESCE(t.cost, 0) AS cost'),
                DB::raw('ABS(COALESCE(p.amount, 0)) AS paid'),
                // bugfix: balance is defined attribute in modal so we should use different name: "balanceD"
                DB::raw('ABS(COALESCE(p.amount, 0)) - COALESCE(t.cost, 0) AS balanced')
            )
            ->leftJoin(DB::raw('(SELECT asset_id, SUM(price) AS cost FROM tasks GROUP BY asset_id) t'), function ($join) {
                $join->on('assets.id', '=', 't.asset_id');
            })
            ->leftJoin(DB::raw('(SELECT asset_id, SUM(IF(type="refund", -ABS(amount), ABS(amount))) AS amount FROM payments GROUP BY asset_id) p'), function ($join) {
                $join->on('assets.id', '=', 'p.asset_id');
            })
            ->having('balanced', '<', 0)
            ->orderByDesc('id');
    }
}
