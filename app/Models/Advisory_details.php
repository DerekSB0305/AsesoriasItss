<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisory_details extends Model
{
    /** @use HasFactory<\Database\Factories\AdvisoryDetailsFactory> */
    use HasFactory;

    protected $primaryKey = 'advisory_detail_id';
    protected $fillable = ['request_id', 'status', 'observations'];

    public function request()
    {
        return $this->belongsTo(Requests::class, 'request_id', 'request_id');
    }

    // Relación con asesorías
    public function advisories()
    {
        return $this->hasMany(Advisories::class, 'advisory_detail_id', 'advisory_detail_id');
    }
}
