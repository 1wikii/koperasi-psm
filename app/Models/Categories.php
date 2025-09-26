<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'slug',
        'image',
        'name',
        'description',
        'is_active'
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id', 'id');
    }
}
