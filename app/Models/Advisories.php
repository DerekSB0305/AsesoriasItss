<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisories extends Model
{
    use HasFactory;

    protected $primaryKey = 'advisory_id';

    protected $fillable = [
        'teacher_subject_id',
        'advisory_detail_id',
        'start_date',
        'end_date',
        'day_of_week',
        'start_time',
        'end_time',
        'classroom',
        'building',
        'assignment_file'
    ];

    // maestro con ASIGNACIÓN
    public function teacherSubject()
    {
        return $this->belongsTo(
            TeacherSubject::class,
            'teacher_subject_id',
            'teacher_subject_id'
        );
    }

    public function detail()
    {
        return $this->belongsTo(
            Advisory_details::class,
            'advisory_detail_id',
            'advisory_detail_id'
        );
    }

    public function advisoryDetail()
    {
        return $this->belongsTo(
            Advisory_details::class,
            'advisory_detail_id',
            'advisory_detail_id'
        );
    }

    // Maestro directo
    public function teacher()
    {
        return $this->hasOneThrough(
            Teacher::class,
            TeacherSubject::class,
            'teacher_subject_id',
            'teacher_user',
            'teacher_subject_id',
            'teacher_user'
        );
    }

    // Alumno mediante request_id
    public function student()
    {
        return $this->hasOneThrough(
            Student::class,
            Requests::class,
            'request_id',
            'enrollment',
            'advisory_detail_id',
            'enrollment'
        );
    }

    public function getRouteKeyName()
    {
        return 'advisory_id';
    }

    public function reports()
    {
        return $this->hasMany(AdvisoryReport::class, 'advisory_id', 'advisory_id');
    }

    public function requests()
    {
        return $this->hasMany(Requests::class, 'enrollment', 'enrollment');
    }
}
