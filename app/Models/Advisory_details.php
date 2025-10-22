<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisory_details extends Model
{
    /** @use HasFactory<\Database\Factories\AdvisoryDetailsFactory> */
    use HasFactory;

    protected $primaryKey = 'advisory_detail_id';
    protected $fillable = ['enrollment', 'status', 'observations'];

    // Pertenece a un alumno
    public function student()
    {
        return $this->belongsTo(Student::class, 'enrollment', 'enrollment');
    }

    // Relación con asesorías
    public function advisories()
    {
        return $this->hasMany(Advisories::class, 'advisory_detail_id', 'advisory_detail_id');
    }
}
