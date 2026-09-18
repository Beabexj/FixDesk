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
            'received_repairs' => Repair::where('status', Repair::STATUS_RECEIVED)->count(),
            'inspection_repairs' => Repair::where('status', Repair::STATUS_INSPECTION)->count(),
            'in_progress_repairs' => Repair::whereIn('status', [Repair::STATUS_IN_PROGRESS, Repair::STATUS_WAITING_PARTS])->count(),
            'completed_repairs' => Repair::whereIn('status', [Repair::STATUS_COMPLETED, Repair::STATUS_DELIVERED])->count(),
            'total_customers' => Customer::count(),
            'total_revenue' => Repair::whereIn('status', [Repair::STATUS_COMPLETED, Repair::STATUS_DELIVERED])->sum('total_cost'),
        ];

        $recent_repairs = Repair::with(['customer', 'technician'])
            ->latest('received_at')
            ->take(6)
            ->get();

        $recent_customers = Customer::latest()
            ->take(5)
            ->get();

        $statuses = Repair::statuses();

        return view('dashboard.index', compact('stats', 'recent_repairs', 'recent_customers', 'statuses'));
    }
}
