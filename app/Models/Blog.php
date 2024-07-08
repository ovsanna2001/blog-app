<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class Blog extends Model
{
    use HasFactory;
    // use SoftDeletes;

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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($blog) {
            Log::info('Attempting to soft delete comments for blog ID: ' . $blog->id);
            $blog->comments()->chunkById(100, function ($comments) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            });
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}

