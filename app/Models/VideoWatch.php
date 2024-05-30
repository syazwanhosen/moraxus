<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoWatch extends Model
{
    protected $table = 'video_watched';
    protected $fillable = ['organization_id'];
}
