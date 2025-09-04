<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $primaryKey = 'enrollment'; // matrícula como PK
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['enrollment', 'last_name_father', 'last_name_mother', 'first_name', 'semester', 'career_id', 'gender', 'age', 'teacher_id'];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
