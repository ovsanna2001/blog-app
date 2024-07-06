<?php

namespace App\Observers;

use App\Models\Blog;

class BlogObserver
{
    public function deleting(Blog $blog)
    {
        // Soft delete comments related to this blog
        $blog->comments->each(function ($comment) {
            $comment->delete();
        });
    }
}
