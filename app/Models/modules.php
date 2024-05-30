<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modules extends Model
{
    protected $table="modules";
    protected $fillable=['file_name', 'file_path', 'file_type', 'module_name', 'description', 'organization_id', 'stage'];
}
