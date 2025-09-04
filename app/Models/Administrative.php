<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrative extends Model
{
    /** @use HasFactory<\Database\Factories\AdministrativeFactory> */
    use HasFactory;

    protected $fillable = ['first_name', 'last_name_father', 'last_name_mother', 'position', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
