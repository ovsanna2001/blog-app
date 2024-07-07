<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'blog_id',
        'user_id'
    ];

    protected static function booted()
    {
        static::deleting(function ($tag) {
            $tag->blogs()->detach();
        });
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tags');
    }
    


}
