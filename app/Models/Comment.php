<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'profile_id',
        'user_id'
    ];

    public function administrators(): HasMany
    {
        return $this->hasMany(Administrator::class);
    }

    public function profils(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

}
