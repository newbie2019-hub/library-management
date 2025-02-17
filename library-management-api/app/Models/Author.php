<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = ['author'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
