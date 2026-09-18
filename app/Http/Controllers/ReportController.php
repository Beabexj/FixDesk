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

        $totalIncome = Repair::whereIn('status', [Repair::STATUS_COMPLETED, Repair::STATUS_DELIVERED])->sum('total_cost');
        $estimatedPending = Repair::whereIn('status', [
            Repair::STATUS_RECEIVED,
            Repair::STATUS_INSPECTION,
            Repair::STATUS_IN_PROGRESS,
            Repair::STATUS_WAITING_PARTS,
        ])->sum('estimated_cost');

        $completedRepairs = Repair::with(['customer', 'technician'])
            ->whereIn('status', [Repair::STATUS_COMPLETED, Repair::STATUS_DELIVERED])
            ->latest('completed_at')
            ->take(10)
            ->get();

        return view('reports.index', compact('statusCounts', 'deviceCounts', 'totalIncome', 'estimatedPending', 'completedRepairs'));
    }
}
