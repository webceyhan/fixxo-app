<?php

namespace App\Http\Controllers;

use App\Enums\Interval;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Ticket;
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

    private static function generateStats($query, $interval)
    {
        $fx = self::INTERVAL_FX[$interval];

        $result =  $query
            ->since($interval)
            ->selectRaw($fx . '(created_at) AS date')
            ->selectRaw('COUNT(id) AS amount')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $result->pluck('date'),
            'values' => $result->pluck('amount'),
            'value' => $result->sum('amount'),
        ];
    }

    private static function getLatestTickets($interval)
    {
        return Ticket::query()
            ->with(['device', 'customer'])
            ->since($interval)
            ->latest('id')
            ->limit(5);
    }

    private function getIncomeStats($interval)
    {
        // TODO: put this query somewhere else!
        // get mysql date function based on the given interval
        $fx = self::INTERVAL_FX[$interval];

        $result = Task::query()
            ->since($interval)
            ->selectRaw($fx . '(created_at) AS date')
            ->selectRaw('SUM(cost) AS cost')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $result->pluck('date')->map(function ($date) use ($interval) {
                switch ($interval) {
                    case Interval::DAY: // hour
                        return Carbon::today()->setTime($date, 0, 0)->format('H:i');
                    case Interval::WEEK: // day
                        return Carbon::today()->day($date)->format('D');
                    case Interval::MONTH: // week
                        return Carbon::today()->week($date)->format('d M');
                    case Interval::YEAR: // month
                        return Carbon::today()->month($date)->format('M');
                    default:
                        return $date;
                }
            }),
            'values' => $result->pluck('cost'),
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $intervalOptions = [
            Interval::DAY => 'Today',
            Interval::WEEK => 'This Week',
            Interval::MONTH => 'This Month',
            Interval::YEAR => 'This Year',
        ];

        $interval = $request->input('interval', Interval::DAY);

        // get earning stats from last (interval) days
        // with sum of tasks's cost as total cost
        // and sum of payments's amount as total payment
        // TODO: find a better way to do this using eloquent
        $earningStats = [
            [
                'label' => 'expected',
                'value' => Task::since($interval)->sum('cost')
            ],
            [
                'label' => 'received',
                'value' => Payment::since($interval)->sum('amount')
            ]
        ];

        return inertia('Dashboard/Index', [
            'interval' => $interval,
            'intervalOptions' => $intervalOptions,

            // stats
            'newCustomerStats' => self::generateStats(Customer::query(), $interval),
            'newTicketStats' => self::generateStats(Ticket::query(), $interval),
            'newTaskStats' => self::generateStats(Task::query(), $interval),
            'newPaymentStats' => self::generateStats(Payment::query(), $interval),

            // stats
            'incomeStats' => $this->getIncomeStats($interval),
            'ticketStats' => Ticket::stats()->since($interval)->get(),
            'taskStats' => Task::stats()->since($interval)->get(),
            'earningStats' => $earningStats,

            // latest tickets by status
            'ticketsInProgress' => self::getLatestTickets($interval)->inProgress()->get(),
            'ticketsResolved' => self::getLatestTickets($interval)->resolved()->get(),
            'ticketsOutstanding' => self::getLatestTickets($interval)->outstanding()->get(),
            'ticketsOverdue' => self::getLatestTickets($interval)->overdue()->get(),
        ]);
    }
}
