<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = 'trip_itineraries';

    protected $fillable = ['user_id', 'trip_name', 'trip_date'];

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
