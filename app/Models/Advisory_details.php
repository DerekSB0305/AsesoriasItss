<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisory_details extends Model
{
    /** @use HasFactory<\Database\Factories\AdvisoryDetailsFactory> */
    use HasFactory;

    protected $primaryKey = 'advisory_detail_id';
    protected $fillable = ['status', 'observations'];

    // Relación con asesorías
    public function advisories()
    {
        return $this->hasMany(Advisories::class, 'advisory_detail_id', 'advisory_detail_id');
    }


    public function getSubjectAttribute()
    {
        return $this->advisories
            ->first()
            ?->teacherSubject
            ?->subject;
    }


    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'advisory_detail_student',   // tabla pivot
            'advisory_detail_id',        // FK en pivot
            'enrollment',                // FK a students
            'advisory_detail_id',        // PK advisory_details
            'enrollment'                 // PK/FK students
        );
    }

    public function getRouteKeyName()
    {
        return 'advisory_detail_id';
    }

    public function requests()
    {
        return $this->belongsToMany(
            Requests::class,
            'advisory_detail_request',
            'advisory_detail_id',
            'request_id'
        );
    }
}
