<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    protected $fillable = [
        'teacher_subject_id',
        'title',
        'file_path'
    ];

    public function teacherSubject()
    {
        return $this->belongsTo(TeacherSubject::class, 'teacher_subject_id');
    }
    
      public function teacher()
    {
        return $this->teacherSubject->teacher;
    }

    public function subject()
    {
        return $this->teacherSubject->subject;
    }
}
