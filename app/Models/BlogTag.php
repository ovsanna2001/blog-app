<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_id',
        'tag_id'
    ];

    public function blog_tags()
    {
        return $this->belongsToMany(Tag::class,'blog_tags');
    }

    public function tags()
    {
        return $this->blog_tags()->pluck('name');
    }

}
