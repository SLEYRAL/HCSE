<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Administrator extends User
{
    use HasFactory;

    protected $table = 'users';
    public static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('is_admin', true);
        });
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function comment():  BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
