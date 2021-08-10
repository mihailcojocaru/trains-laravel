<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $appends = ["first_car"];

    /**
     * Get all the carts for the train.
     */
    public function cars()
    {
        return $this->hasMany(TrainCar::class);
    }

    public function getFirstCarAttribute()
    {
        return TrainCar::whereTrainId($this->id)->whereCarNumber(1)->first();
    }
}
