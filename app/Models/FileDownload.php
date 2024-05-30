<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDownload extends Model
{
    protected $table = 'files_downloaded';
    protected $fillable = ['organization_id'];
}
