<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'amount',
        'spent',
        'period',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
        'spent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function getPercentageAttribute(): float
    {
        if ($this->amount == 0) {
            return 0;
        }
        return round(($this->spent / $this->amount) * 100, 2);
    }

    public function getRemainingAttribute(): float
    {
        return max(0, $this->amount - $this->spent);
    }

    public function getIsOverBudgetAttribute(): bool
    {
        return $this->spent > $this->amount;
    }

    public function getStatusAttribute(): string
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 100) {
            return 'exceeded';
        } elseif ($percentage >= 90) {
            return 'critical';
        } elseif ($percentage >= 70) {
            return 'warning';
        }
        
        return 'good';
    }
}
