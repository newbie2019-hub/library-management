<?php

namespace App\Models;

use App\Enums\book\DurationType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssuedBook extends Model
{
    /** @use HasFactory<\Database\Factories\IssuedBookFactory> */
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'member_id',
        'book_id',
        'issued_at',
        'return_date',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
            'return_date' => 'datetime'
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOverdue(Builder $query): void
    {
        $query->whereDate('return_date', '<', now())->latest();
    }
}
