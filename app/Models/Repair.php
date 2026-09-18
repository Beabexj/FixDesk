<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repair extends Model
{
    use HasFactory;

    public const STATUS_RECEIVED = 'received';

    public const STATUS_INSPECTION = 'inspection';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_WAITING_PARTS = 'waiting_parts';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_CANCELLED = 'cancelled';

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
     * All available repair statuses with labels and styling.
     *
     * @return array<string, array{label: string, badge_class: string}>
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_RECEIVED => [
                'label' => 'รับเครื่อง',
                'badge_class' => 'bg-slate-100 text-slate-700 border-slate-200',
            ],
            self::STATUS_INSPECTION => [
                'label' => 'ตรวจสอบ',
                'badge_class' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
            ],
            self::STATUS_IN_PROGRESS => [
                'label' => 'กำลังซ่อม',
                'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200',
            ],
            self::STATUS_WAITING_PARTS => [
                'label' => 'รออะไหล่',
                'badge_class' => 'bg-purple-50 text-purple-700 border-purple-200',
            ],
            self::STATUS_COMPLETED => [
                'label' => 'ซ่อมเสร็จ',
                'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            ],
            self::STATUS_DELIVERED => [
                'label' => 'ส่งมอบแล้ว',
                'badge_class' => 'bg-teal-50 text-teal-700 border-teal-200',
            ],
            self::STATUS_CANCELLED => [
                'label' => 'ยกเลิก',
                'badge_class' => 'bg-rose-50 text-rose-700 border-rose-200',
            ],
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status]['label'] ?? $this->status;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return self::statuses()[$this->status]['badge_class'] ?? 'bg-slate-100 text-slate-700 border-slate-200';
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
