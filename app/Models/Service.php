<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * Get the documents for the service.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the projects for the service.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
