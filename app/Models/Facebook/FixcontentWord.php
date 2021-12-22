<?php

namespace App\Models\Facebook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixcontentWord extends Model
{
    use HasFactory;

    protected $table = 'fb_fixcontent_words';
    public $timestamps = false;
}
