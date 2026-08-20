<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description','image','tag','sort_order','status'];

    protected $casts = ['status' => 'boolean'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
