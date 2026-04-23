<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
<<<<<<< HEAD
    protected $fillable = ['user_id', 'trip_name', 'trip_date'];
=======
    protected $table = 'trip_itineraries';

    protected $fillable = ['user_id', 'trip_name', 'trip_date', 'transport_mode', 'starting_location', 'start_lat', 'start_lng'];
>>>>>>> main

    public function attractions()
    {
        return $this->belongsToMany(
            Attraction::class,
            'trip_attractions',
            'trip_id',
            'attraction_id'
        );
    }
}
