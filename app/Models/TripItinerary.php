<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripItinerary extends Model
{
    protected $fillable = ['user_id', 'trip_name', 'trip_date'];

    public function attractions()
    {
        return $this->belongsToMany(Attraction::class, 'trip_attractions', 'trip_id', 'attraction_id')
                    ->withPivot('order')
                    ->orderBy('trip_attractions.order');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}