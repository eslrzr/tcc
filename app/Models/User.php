<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'administration_type_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the administration type that owns the user.
     */
    public function administrationType() : BelongsTo {
        return $this->belongsTo(AdministrationType::class);
    }

    /** 
     * Set user's dark mode preference.
     */
    public function setDarkMode(bool $darkMode): void {
        $this->dark_mode = $darkMode;
        $this->save();
    }

    /**
     * Get user's dark mode preference.
     */
    public function getDarkMode(): bool {
        return $this->dark_mode;
    }
}
