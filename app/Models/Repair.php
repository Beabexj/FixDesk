<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repair extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'repair_code',
        'customer_id',
        'technician_id',
        'device_type',
        'brand',
        'model',
        'serial_number',
        'problem_description',
        'accessories',
        'repair_notes',
        'status',
        'priority',
        'estimated_cost',
        'total_cost',
        'received_at',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'received_at' => 'datetime',
            'completed_at' => 'datetime',
            'estimated_cost' => 'decimal:2',
            'total_cost' => 'decimal:2',
        ];
    }

    /**
     * Customer who owns this repair order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Technician assigned to this repair order.
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    /**
     * Items, parts, or labor services for this repair order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(RepairItem::class);
    }
}
