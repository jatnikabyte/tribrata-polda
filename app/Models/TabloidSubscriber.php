<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TabloidSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'tabloid_id',
        'subscriber_id',
        'subscribed_at',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function tabloid(): BelongsTo
    {
        return $this->belongsTo(Tabloid::class);
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }
}