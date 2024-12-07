<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasUuids, HasFactory, SoftDeletes;

    protected $hidden = ['pivot'];

    protected $fillable = [
        'author_id',
        'isbn_no',
        'title',
        'quantity',
        'price',
        'pages',
        'edition',
        'publisher',
        'series',
        'cover_photo',
        'published_at',
        'purchased_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'purchased_at' => 'datetime',
        ];
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function issuedBooks(): HasMany
    {
        return $this->hasMany(IssuedBook::class);
    }
}
