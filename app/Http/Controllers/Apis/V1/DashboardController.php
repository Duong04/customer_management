<?php

namespace App\Http\Controllers\Apis\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getMonthlyCustomerCount(Request $request)
    {
        $year = $request->query('year', now()->year); 

        $customerData = Customer::selectRaw('
            MONTH(created_at) as month,
            COUNT(*) as total
        ')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $monthlyCounts = array_fill(1, 12, 0);

        foreach ($customerData as $item) {
            $monthlyCounts[(int)$item->month] = (int)$item->total;
        }

        return response()->json([
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'series' => [
                [
                    'name' => 'Số lượng khách hàng',
                    'data' => array_values($monthlyCounts)
                ]
            ]
        ]);
    }

    public function growth(Request $request)
    {
        $year = $request->query('year', Carbon::now()->year);
        $month = $request->query('month', Carbon::now()->month);

        $currentMonth = Carbon::create($year, $month);
        $previousMonth = $currentMonth->copy()->subMonth();

        $current = Customer::whereYear('created_at', $currentMonth->year)
                            ->whereMonth('created_at', $currentMonth->month)
                            ->count();

        $previous = Customer::whereYear('created_at', $previousMonth->year)
                            ->whereMonth('created_at', $previousMonth->month)
                            ->count();

        $growth = $previous > 0 ? round((($current - $previous) / $previous) * 100, 2) : ($current > 0 ? 100 : 0);

        return response()->json([
            'growth' => $growth,
            'current' => $current,
            'previous' => $previous
        ]);
    }

}
