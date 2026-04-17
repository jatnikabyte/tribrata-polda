<?php

namespace App\Models;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasEncryptedId;

    protected $fillable = [
        'outlet_id',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'outlet_users');
    }
}
