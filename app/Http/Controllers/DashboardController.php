<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Task;
use App\Models\Ticket;
use App\Queries\DashboardQuery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
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
            'earningStats' => DashboardQuery::earningStats(),

            // recent tickets by status
            'ticketsInProgress' => DashboardQuery::recentTickets()->inProgress()->get(),
            'ticketsResolved' => DashboardQuery::recentTickets()->resolved()->get(),
            'ticketsOutstanding' => DashboardQuery::recentTickets()->outstanding()->get(),
            'ticketsOverdue' => DashboardQuery::recentTickets()->overdue()->get(),
        ]);
    }
}
