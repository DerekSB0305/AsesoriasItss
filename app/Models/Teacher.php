<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $primaryKey = 'teacher_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'teacher_user', 'name', 'last_name_f', 'last_name_m',
        'career_id', 'degree', 'tutor', 'science_department', 'schedule'
    ];

    // Carrera del maestro
    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }

    // Relación con materias (N:M)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects', 'teacher_user', 'subject_id');
    }

    // Relación correcta con teacher_subjects
    public function teacherSubjects()
    {
        return $this->hasMany(\App\Models\TeacherSubject::class, 'teacher_user', 'teacher_user');
    }

    // Relación con alumnos
    public function students()
    {
        return $this->hasMany(Student::class, 'teacher_user', 'teacher_user');
    }

    // Relación con asesorías
    public function advisories()
    {
        return $this->hasMany(Advisories::class, 'teacher_user', 'teacher_user');
    }

    // Relación con el usuario del sistema
    public function userRelation()
    {
        return $this->belongsTo(User::class, 'teacher_user', 'user');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($teacher) {
            // Eliminar usuario asociado
            \App\Models\User::where('user', $teacher->teacher_user)->delete();
        });
    }
}
