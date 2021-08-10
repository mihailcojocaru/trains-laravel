<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainCar extends Model
{
    protected $hidden = array('created_at', 'updated_at');

    /**
     * Get the train this car belongs to.
     */
    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    /**
     * Get the type of the car.
     */
    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    static function reorderCars($train_id, $int)
    {
        $trainCars = TrainCar::whereTrainId($train_id)->get()->sortBy('car_number');

        foreach ($trainCars as $trainCar)
        {
            $trainCar->car_number = $int;
            $trainCar->save();

            $int++;
        }
    }

    protected $fillable = [
        'train_id',
        'car_type_id',
        'weight',
    ];
}
