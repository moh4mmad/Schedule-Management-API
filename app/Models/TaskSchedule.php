<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'task_title',
        'tast_description',
        'start_date',
        'end_date',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
