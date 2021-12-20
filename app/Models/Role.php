<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // many to many
    // Users of a Role
    public function users() {
        return $this->belongsToMany('App\Models\User');
    }
}
