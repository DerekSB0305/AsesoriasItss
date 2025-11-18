<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;

    protected $primaryKey = 'teacher_user';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'teacher_user', 'name', 'last_name_f', 'last_name_m',
        'career_id', 'degree', 'tutor', 'science_department', 'schedule'
    ];

    // Un profesor pertenece a una carrera
    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }

    // Relación con materias (N:M)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects', 'teacher_user', 'subject_id');
    }

    // Relación con alumnos (1:N)
    public function students()
    {
        return $this->hasMany(Student::class, 'teacher_user', 'teacher_user');
    }

    // Relación con asesorías
    public function advisories()
    {
        return $this->hasMany(Advisories::class, 'teacher_user', 'teacher_user');
    }

    public function userRelation()
    {
        return $this->belongsTo(User::class, 'teacher_user', 'user');
    }

     protected static function boot()
{
    parent::boot();

    static::deleting(function ($teacher) {
        // Borrar el usuario con esa matrícula
        \App\Models\User::where('user', $teacher->teacher_user)
                        ->delete();
    });
}
}
