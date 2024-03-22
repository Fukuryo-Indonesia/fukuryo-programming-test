<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    function scopeSearch($query, array $params)
    {
        $query->when($params['search'] ?? false, fn ($query, $search) => ($query->where('name', "LIKE", "%$search%")));

        return $query;
    }
}
