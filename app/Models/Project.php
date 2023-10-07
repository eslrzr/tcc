<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    public static $STATUS_TO_DO_ID = '_todo';
    public static $STATUS_TO_DO = 'N';
    public static $STATUS_IN_PROGRESS_ID = '_working';
    public static $STATUS_IN_PROGRESS = 'A';
    public static $STATUS_DONE_ID = '_done';
    public static $STATUS_DONE = 'F';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'process_status',
        'service_id',
    ];

    /**
     * Get the medias for the project.
     */
    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
