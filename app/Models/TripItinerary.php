<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['user_id', 'trip_name', 'trip_date'];

    public function attractions()
    {
        return $this->belongsToMany(Attraction::class, 'trip_attraction', 'trip_id', 'attraction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}