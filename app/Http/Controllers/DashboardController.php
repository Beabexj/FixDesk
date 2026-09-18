<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Repair;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display dashboard summary and recent activities.
     */
    public function index(): View
    {
        $stats = [
            'total_repairs' => Repair::count(),
            'pending_repairs' => Repair::where('status', 'pending')->count(),
            'in_progress_repairs' => Repair::where('status', 'in_progress')->count(),
            'completed_repairs' => Repair::where('status', 'completed')->count(),
            'total_customers' => Customer::count(),
            'total_revenue' => Repair::where('status', 'completed')->sum('total_cost'),
        ];

        $recent_repairs = Repair::with(['customer', 'technician'])
            ->latest()
            ->take(6)
            ->get();

        $recent_customers = Customer::latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recent_repairs', 'recent_customers'));
    }
}
