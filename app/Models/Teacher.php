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
        'teacher_user',
        'name',
        'last_name_f',
        'last_name_m',
        'career_id',
        'degree',
        'tutor',
        'science_department',
        'schedule'
    ];

    // Carrera del maestro
    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }

    // Relación con TeacherSubject
    public function teacherSubjects()
    {
        return $this->hasMany(\App\Models\TeacherSubject::class, 'teacher_user', 'teacher_user');
    }

    // Relación con asesorías directas
    public function advisories()
    {
        return $this->hasManyThrough(
            Advisories::class,      
            TeacherSubject::class, 
            'teacher_user',                  
            'teacher_subject_id',               
            'teacher_user',                   
            'teacher_subject_id'                
        );
    }


    public function manuals()
    {
        return $this->hasManyThrough(
            Manual::class,
            TeacherSubject::class,
            'teacher_user',
            'teacher_subject_id',
            'teacher_user',
            'teacher_subject_id'
        );
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
            \App\Models\User::where('user', $teacher->teacher_user)->delete();
        });
    }
}
