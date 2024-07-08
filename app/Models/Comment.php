<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

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

    public function delete()
    {
        try {
            Log::info('Attempting to delete comment with ID: ' . $this->id);
            return $this->forceDelete();
        } catch (\Exception $e) {
            Log::error('Error deleting comment with ID: ' . $this->id . ' - ' . $e->getMessage());
            throw $e;
        }
    }
}
