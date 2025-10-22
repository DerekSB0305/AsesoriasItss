<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

        protected $primaryKey = 'enrollment';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'enrollment', 'last_name_f', 'last_name_m', 'name',
        'semester', 'career_id', 'gender', 'age', 'teacher_user'
    ];

    // Un alumno pertenece a una carrera
    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }

    // Un alumno tiene un profesor tutor
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user', 'teacher_user');
    }

    // Relación con materias (N:M)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subjects', 'enrollment', 'subject_id');
    }

    // Relación con detalles de asesoría
    public function advisoryDetails()
    {
        return $this->hasMany(Advisory_details::class, 'enrollment', 'enrollment');
    }
}
