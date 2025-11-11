<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherSubjectFactory> */
    use HasFactory;

      protected $primaryKey = 'teacher_subject_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['teacher_user','subject_id','career_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}
