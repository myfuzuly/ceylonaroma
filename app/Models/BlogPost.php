<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_posts';

    protected $fillable = [
        'title','slug','category','excerpt','content','image','published_at','status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status'       => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
