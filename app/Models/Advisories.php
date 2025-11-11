<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisories extends Model
{
    /** @use HasFactory<\Database\Factories\AdvisoriesFactory> */
    use HasFactory;

     protected $primaryKey = 'advisory_id';
    protected $fillable = [
        'teacher_subject_id', 'advisory_detail_id',
        'schedule', 'classroom', 'building', 'assignment_file'
    ];

    public function teacherSubject()
    {
        return $this->belongsTo(TeacherSubject::class, 'teacher_subject_id', 'teacher_subject_id');
    }

    public function advisoryDetail()
    {
        return $this->belongsTo(Advisory_details::class, 'advisory_detail_id', 'advisory_detail_id');
    }

    //  A través de teacherSubject se puede obtener el maestro
    public function teacher()
    {
        return $this->hasOneThrough(
            Teacher::class,
            TeacherSubject::class,
            'teacher_subject_id',   // FK en teacher_subjects
            'teacher_user',         // FK en teachers
            'teacher_subject_id',   // FK local en advisories
            'teacher_user'          // FK local en teacher_subjects
        );
    }

    // 🔹 A través del detalle se puede acceder al alumno y materia
    public function student()
    {
        return $this->hasOneThrough(
            Student::class,
            Requests::class,
            'request_id',    // FK en requests
            'enrollment',    // FK en students
            'advisory_detail_id', // FK local en advisories -> detail
            'enrollment'     // FK local en requests
        );
    }
}
