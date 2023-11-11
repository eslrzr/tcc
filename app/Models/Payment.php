<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public static $STATUS_PAID = 1;
    public static $STATUS_UNPAID = 0;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'value',
        'status',
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
    * Get the employee that owns the payment.
    */
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
