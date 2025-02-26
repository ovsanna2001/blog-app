<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'description',
        'posted_at',
        'user_id',
    ];

    protected $dates = ['posted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'blog_tags');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}

