<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'morning',
        'afternoon',
        'night',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
