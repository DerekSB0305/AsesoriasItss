<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'enrollment', 'advisory_id', 'teacher_user',
        'q1','q2','q3','q4','q5','q6','q7','q8','q9','q10','q11'
    ];

    public function advisory()
    {
        return $this->belongsTo(Advisories::class, 'advisory_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'enrollment', 'enrollment');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user', 'teacher_user');
    }
}

