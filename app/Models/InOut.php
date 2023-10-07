<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InOut extends Model
{
    use HasFactory;

    public static $TYPE_IN = 'IN';
    public static $TYPE_OUT = 'OUT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'value',
        'type',
        'cash_id',
        'employee_id',
        'service_id',
    ];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];
}
