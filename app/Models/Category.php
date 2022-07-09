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

    public function getDateAttribute($value){
        // return  2020-08-17
        $date = date('Y-m-d',strtotime($value));
        return $date;
    }


    public function expenses()
    {
        return $this->hasMany(Expense::class, 'category_id', 'id');
    }
}
