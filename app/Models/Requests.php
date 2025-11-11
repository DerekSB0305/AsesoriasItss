<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    /** @use HasFactory<\Database\Factories\RequestsFactory> */
    use HasFactory;

    protected $primaryKey = 'request_id';
    protected $fillable = [
        'enrollment', 'teacher_user', 'subject_id', 'reason', 'canalization_file'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'enrollment', 'enrollment');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user', 'teacher_user');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function advisoryDetails()
    {
        return $this->hasMany(Advisory_details::class, 'request_id', 'request_id');
    }
}
