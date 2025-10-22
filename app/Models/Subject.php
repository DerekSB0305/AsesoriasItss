<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $primaryKey = 'subject_id';
    protected $fillable = ['name', 'career_id', 'period'];

    // Pertenece a una carrera
    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }

    // Relación con profesores
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subjects', 'subject_id', 'teacher_user');
    }

    // Relación con alumnos
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_subjects', 'subject_id', 'enrollment');
    }

    // Relación con asesorías
    public function advisories()
    {
        return $this->hasMany(Advisories::class, 'subject_id', 'subject_id');
    }
}
