<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixcontent extends Model
{
    use HasFactory;

    public function scopeList(Builder $query, int $take, int $skip): Builder
    {
        return $query->latest()
            ->limit($take)
            ->offset($skip);
    }
}
