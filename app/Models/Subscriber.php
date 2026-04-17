<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{
    use HasFactory;

    protected $table = 'subscribers';

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'avatar',
        'subscribed_at',
        'is_active',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function activate()
    {
        $this->update([
            'is_active' => true,
            'subscribed_at' => now(),
        ]);
    }

    public function deactivate()
    {
        $this->update([
            'is_active' => false,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function tabloids()
    {
        return $this->belongsToMany(Tabloid::class, 'tabloid_subscribers', 'subscriber_id', 'tabloid_id')
            ->withPivot('subscribed_at')
            ->withTimestamps();
    }
}
