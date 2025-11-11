<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherSubjectFactory> */
    use HasFactory;

    protected $fillable = ['teacher_id', 'subject_id', 'career_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user', 'teacher_user');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }

    public function advisories()
    {
        return $this->hasMany(Advisories::class, 'teacher_subject_id', 'teacher_subject_id');
    }
}
