<?php

namespace App\Models;

use App\Traits\Blameable;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabloid extends Model
{
    use Blameable,HasFactory, SoftDeletes,HasEncryptedId;

    protected $fillable = [
        'title',
        'cover',
        'file_pdf',
        'edition_of',
        'is_active',
        'view_count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'edition_of' => 'integer',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'tabloid_subscribers', 'tabloid_id', 'subscriber_id')
            ->withPivot('subscribed_at')
            ->withTimestamps();
    }
}
