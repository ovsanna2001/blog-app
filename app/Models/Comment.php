<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'content',
        'blog_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

   // Override the delete method to hard delete
   public function forceDelete()
   {
       return parent::forceDelete();
   }

   public function delete()
    {
        if (method_exists($this, 'bootSoftDeletes')) {
            return $this->forceDelete();
        }

        return parent::delete();
    }
}
