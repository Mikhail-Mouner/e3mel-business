<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'rating',
        'view',
        'level',
        'hours',
        'active',
        'category_id',
    ];

    public function scopeActive($query)
    {
        return $query->whereActive( TRUE );
    }

    public function scopeActiveCategory($query)
    {
        return $query->whereHas( 'category', function ($q) {
            return $q->Active();
        } );
    }

    public function category()
    {
        return $this->belongsTo( Category::class );
    }

}
