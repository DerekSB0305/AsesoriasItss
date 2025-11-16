<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrative extends Model
{
    /** @use HasFactory<\Database\Factories\AdministrativeFactory> */
    use HasFactory;

    protected $primaryKey = 'administrative_user';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'administrative_user', 'name', 'last_name_f', 'last_name_m',
        'position', 'career_id', 'canalization_file'
    ];

    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id', 'career_id');
    }
}
