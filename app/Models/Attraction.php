<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    use HasFactory;

    protected $primaryKey = 'attraction_id';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'distance',
        'image',
        'location',
        'latitude',
        'longitude',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
