<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'type',
        'action',
        'message',
        'user_id',
        'ip_address',
    ];

    /**
     * Get the user that owns the system log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
