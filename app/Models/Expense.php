<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'cost'];

    // An expense belongs to only 1 user
    public function user() {
        return $this->belongsTo(User::class);
    }

}
