<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RepairController extends Controller
{
    /**
     * Display a listing of repair orders.
     */
    public function index(Request $request): View
    {
        $query = Repair::query()->with(['customer', 'technician']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('repair_code', 'like', "%{$search}%")
                    ->orWhere('device_type', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        $repairs = $query->latest('received_at')->paginate(10)->withQueryString();

        return view('repairs.index', compact('repairs'));
    }

    /**
     * Show the form for creating a new repair order.
     */
    public function create(): View
    {
        $customers = Customer::orderBy('name')->get();
        $technicians = User::where('is_active', true)->orderBy('name')->get();

        return view('repairs.create', compact('customers', 'technicians'));
    }

    /**
     * Store a newly created repair order in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'technician_id' => ['nullable', 'exists:users,id'],
            'device_type' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'problem_description' => ['required', 'string'],
            'accessories' => ['nullable', 'string'],
            'repair_notes' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
            'status' => ['required', 'in:received,inspection,in_progress,waiting_parts,completed,delivered,cancelled'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
        ]);

        $repairCode = 'FX-'.date('Ymd').'-'.strtoupper(Str::random(4));
        $validated['repair_code'] = $repairCode;
        $validated['received_at'] = now();
        $validated['estimated_cost'] = $validated['estimated_cost'] ?? 0;
        $validated['total_cost'] = 0;

        $repair = Repair::create($validated);

        return redirect()->route('repairs.show', $repair)
            ->with('success', "บันทึกใบแจ้งซ่อมรหัส {$repair->repair_code} เรียบร้อยแล้ว");
    }

    /**
     * Display the specified repair order.
     */
    public function show(Repair $repair): View
    {
        $repair->load(['customer', 'technician', 'items']);

        return view('repairs.show', compact('repair'));
    }

    /**
     * Show the form for editing the specified repair order.
     */
    public function edit(Repair $repair): View
    {
        $customers = Customer::orderBy('name')->get();
        $technicians = User::where('is_active', true)->orderBy('name')->get();
        $repair->load('items');

        return view('repairs.edit', compact('repair', 'customers', 'technicians'));
    }

    /**
     * Update the specified repair order in storage.
     */
    public function update(Request $request, Repair $repair): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'technician_id' => ['nullable', 'exists:users,id'],
            'device_type' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:100'],
            'problem_description' => ['required', 'string'],
            'accessories' => ['nullable', 'string'],
            'repair_notes' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
            'status' => ['required', 'in:received,inspection,in_progress,waiting_parts,completed,delivered,cancelled'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
            'total_cost' => ['nullable', 'numeric', 'min:0'],
        ]);

        if (in_array($validated['status'], ['completed', 'delivered']) && ! $repair->completed_at) {
            $validated['completed_at'] = now();
        }

        $repair->update($validated);

        return redirect()->route('repairs.show', $repair)
            ->with('success', 'ปรับปรุงข้อมูลใบแจ้งซ่อมเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified repair order from storage.
     */
    public function destroy(Repair $repair): RedirectResponse
    {
        $repair->delete();

        return redirect()->route('repairs.index')
            ->with('success', 'ลบใบแจ้งซ่อมเรียบร้อยแล้ว');
    }
}
