<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";
    protected $fillable = [
        'id',
        'name',
        'user_id',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'category_id', 'id');
    }
}
