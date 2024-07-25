<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id', 'title', 'description', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
