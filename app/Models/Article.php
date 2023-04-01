<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'image',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class,'id' ,'category_id');
    }

    public function users()
    {
        return $this->hasMany(User::class,'id' ,'user_id');
    }
}
