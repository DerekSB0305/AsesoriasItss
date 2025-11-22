<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvisoryReport extends Model
{
        protected $fillable = [
        'advisory_id',
        'description',
        'file_path',
    ];

    public function advisory()
    {
        return $this->belongsTo(Advisories::class, 'advisory_id', 'advisory_id');
    }
}
