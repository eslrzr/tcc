<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'work_status',
        'admission_date',
        'salary',
        'role_id',
    ];

    /**
     * Get the role that owns the employee.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(EmployeeRole::class);
    }
}
