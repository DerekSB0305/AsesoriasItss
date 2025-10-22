<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisories extends Model
{
    /** @use HasFactory<\Database\Factories\AdvisoriesFactory> */
    use HasFactory;

     protected $primaryKey = 'advisory_id';
    protected $fillable = [
        'teacher_user', 'advisory_detail_id', 'subject_id',
        'schedule', 'classroom', 'building', 'assignment_file'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user', 'teacher_user');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function advisoryDetail()
    {
        return $this->belongsTo(Advisory_details::class, 'advisory_detail_id', 'advisory_detail_id');
    }
}
