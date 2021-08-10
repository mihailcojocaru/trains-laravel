<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use App\Models\Train;
use App\Models\TrainCar;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trains = Train::all();
        return view('welcome')->with('trains', $trains);
    }

    /**
     * It creates a new Train with an engine.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $train = new Train();
        $train->name = 'SN'.rand(1000,9999);
        $train->save();

        $firstCar = new TrainCar();
        $firstCar->train_id = $train->id;
        $firstCar->car_type_id = 1;
        $firstCar->car_number = 1;
        $firstCar->weight = 10000;
        $firstCar->save();

        return redirect()->route('trains.show', $train->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'train_id' => 'required',
            'car_type_id' => 'required',
            'location' => 'required',
            'weight' => 'required',
        ]);

        $trainCars = TrainCar::whereTrainId($request->train_id)->get();

        if($request->location == 1)
        {
            TrainCar::reorderCars($request->train_id, 2);
        }

        $trainCar = TrainCar::create($request->all());
        if($request->location == 1) {
            $trainCar->car_number = 1;
        } else {
            $trainCar->car_number = $trainCars->count() + 1;
        }
        $trainCar->save();

        return redirect()->route('trains.show', $request->train_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  Train  $train
     * @return View
     */
    public function show(Train $train)
    {
        $carTypes = CarType::pluck('name', 'id');
        return view('train')
            ->with('train', $train)
            ->with('carTypes', $carTypes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Train $train
     * @return \Illuminate\Http\Response
     */
    public function destroyFirstCar(Train $train)
    {
        TrainCar::whereTrainId($train->id)->whereCarNumber(1)->first()->delete();
        TrainCar::reorderCars($train->id, 1);
        return redirect()->route('trains.show', $train->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Train $train
     * @return \Illuminate\Http\Response
     */
    public function destroyLastCar(Train $train)
    {
        TrainCar::whereTrainId($train->id)->whereCarNumber($train->cars->count())->first()->delete();
        return redirect()->route('trains.show', $train->id);
    }
}
