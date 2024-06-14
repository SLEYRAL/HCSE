<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'status',
        'image',
        'user_id'
    ];

    public function administrator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }



}
