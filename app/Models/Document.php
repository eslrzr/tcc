<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    public static $LINKED_TO_EMPLOYEE = 'E';
    public static $LINKED_TO_SERVICE = 'S';

    public static $PROCESS_STATUS_NOT_APPLICABLE = 'X';
    public static $PROCESS_STATUS_PENDING = 'N';
    public static $PROCESS_STATUS_IN_PROGRESS = 'A';
    public static $PROCESS_STATUS_FINISHED = 'F';
    public static $PROCESS_STATUS_REJECTED = 'R';


    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'process_status',
        'employee_id',
        'service_id',
        'document_type_id',
        'user_id',
    ];

    /**
     * Get the employee that owns the document.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the service that owns the document.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the document type that owns the document.
     */
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
