<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'document_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['name', 'file_path'];



    public function getRouteKeyName()
    {
        return 'document_id';
    }
    
}
