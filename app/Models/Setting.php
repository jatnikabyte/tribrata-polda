<?php

namespace App\Models;
use App\Traits\Blameable;
use App\Traits\HasEncryptedId;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Blameable, HasEncryptedId;

    protected $fillable = [
        'is_dev',
        'keyword',
        'value',
        'type',
        'created_by',
        'updated_by',
    ];
}
