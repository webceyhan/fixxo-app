<?php

namespace App\Http\Controllers;

use App\Enums\Interval;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Task;
use App\Models\Ticket;
use App\Queries\DashboardQuery;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class DashboardController extends Controller
{
    const INTERVAL_FX = [
        Interval::DAY => 'hour',
        Interval::WEEK => 'day',
        Interval::MONTH => 'week',
        Interval::YEAR => 'month',
    ];

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $interval = $request->input('interval', Interval::DAY);

        // get earning stats from last (interval) days
        // with sum of tasks's cost as total cost
        // and sum of transactions's amount as total transaction
        // TODO: find a better way to do this using eloquent
        $earningStats = [
            [
                'label' => 'expected',
                'value' => Task::since($interval)->sum('cost')
            ],
            [
                'label' => 'received',
                'value' => Transaction::since($interval)->sum('amount')
            ]
        ];

        return inertia('Dashboard/Index', [
            'filters' => DashboardQuery::filters(),

            // chart data
            'incomeChartData' => DashboardQuery::chartDataForIncome(),
            'customerChartData' => DashboardQuery::chartDataFor(Customer::query()),
            'ticketChartData' => DashboardQuery::chartDataFor(Ticket::query()),
            'taskChartData' => DashboardQuery::chartDataFor(Task::query()),
            'transactionChartData' => DashboardQuery::chartDataFor(Transaction::query()),

            // stats
            'ticketStats' => DashboardQuery::ticketStats(),
            'taskStats' => DashboardQuery::taskStats(),
            'earningStats' => $earningStats,

            // latest tickets by status
            'ticketsInProgress' => DashboardQuery::recentTickets()->inProgress()->get(),
            'ticketsResolved' => DashboardQuery::recentTickets()->resolved()->get(),
            'ticketsOutstanding' => DashboardQuery::recentTickets()->outstanding()->get(),
            'ticketsOverdue' => DashboardQuery::recentTickets()->overdue()->get(),
        ]);
    }
}
