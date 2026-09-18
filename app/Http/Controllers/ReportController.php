<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display repair analytics and financial reports.
     */
    public function index(Request $request): View
    {
        $statusCounts = Repair::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        $deviceCounts = Repair::select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        $totalIncome = Repair::where('status', 'completed')->sum('total_cost');
        $estimatedPending = Repair::whereIn('status', ['pending', 'in_progress', 'waiting_parts'])->sum('estimated_cost');

        $completedRepairs = Repair::with(['customer', 'technician'])
            ->where('status', 'completed')
            ->latest('completed_at')
            ->take(10)
            ->get();

        return view('reports.index', compact('statusCounts', 'deviceCounts', 'totalIncome', 'estimatedPending', 'completedRepairs'));
    }
}
