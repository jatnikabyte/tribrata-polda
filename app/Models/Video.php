<?php

namespace App\Models;

use App\Traits\Blameable;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use Blameable, HasFactory, SoftDeletes,HasEncryptedId;

    protected $fillable = [
        'title',
        'slug',
        'badge',
        'badge_color',
        'video_link',
        'cover',
        'description',
        'is_active',
        'view_count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
