<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'line_id',
        'address',
        'notes',
    ];

    /**
     * Repairs associated with this customer.
     */
    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }
}
