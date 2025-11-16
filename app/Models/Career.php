<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    /** @use HasFactory<\Database\Factories\CareerFactory> */
    use HasFactory;
    protected $table = 'careers';
    protected $primaryKey = 'career_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['name', 'plan_study', 'period'];

    // Relación con materias
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'career_id', 'career_id');
    }

    // Relación con profesores
    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'career_id', 'career_id');
    }

    // Relación con estudiantes
    public function students()
    {
        return $this->hasMany(Student::class, 'career_id', 'career_id');
    }

    // Relación con administrativos
    public function administratives()
    {
        return $this->hasMany(Administrative::class, 'career_id', 'career_id');
    }
}
