<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RepairOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_id',
        'device_type', 'brand', 'model', 'serial',
        'issue_description', 'diagnosed_problem', 'technician_id',
        'status',
        'estimated_cost', 'final_cost', 'warranty_months',
        'received_at', 'ready_at', 'delivered_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_cost' => 'decimal:2',
            'final_cost' => 'decimal:2',
            'warranty_months' => 'integer',
            'received_at' => 'datetime',
            'ready_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(RepairStatusHistory::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
