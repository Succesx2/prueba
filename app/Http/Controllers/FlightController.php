<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Airplane;
use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $data['airlines'] = Airline::where('is_delete', false)->get();
        $data['airplanes'] = Airplane::where('is_delete', false)->get();
        $data['airports'] = Airport::where('is_delete', false)->get();
        $data['flights'] = [];

        return view('flight.index')->with($data);
    }

    public function view_ce_flight(Request $request)
    {

        $airlines = Airline::where('is_delete', false)->get();
        $airplanes = Airplane::where('is_delete', false)->get();
        $airports = Airport::where('is_delete', false)->get();

        $flight_id = $request->input('flight_id') ?? 0;

        if ($flight_id == 0){

            $flight = new Flight();

        } else{
            $flight = Flight::findOrFail($flight_id);
        }


        $flight_data['flight'] = $flight;
        $flight_data['airlines'] = $airlines;
        $flight_data['airplanes'] = $airplanes;
        $flight_data['airports'] = $airports;
        $data['body'] = view('flight.ce_flight')->with($flight_data)->render();
        return $data;
    }


    function get_flights(Request $request)
    {
        $search = $request->input('search') ?? '';
        $airline_id = $request->input('airline_id') ?? 0;
        $airplane_id = $request->input('airplane_id') ?? 0;
        $airport_id = $request->input('airport_id') ?? 0;

        $flights = Flight::where('is_delete', false);
        foreach ($flights as $flight){
            $is_full = "";
            if($flight->is_full == 0){
                $is_full = "Vacio";
            } elseif($flight->is_full == 1){
                $is_full = "Tiene Espacio";}

            $flights->is_full = $is_full;}

        if ($search != ''){

            $flights = $flights->where(function ($q) use ($search) {
                $q->where('code','like', "%$search%")
                ;
            });


        }
        if ($airline_id != 0){
            $flights = $flights->where('airline_id', $airline_id);
        }if ($airplane_id != 0){
        $flights = $flights->where('airplane_id', $airplane_id);
    }if ($airport_id != 0){
        $flights = $flights->where('airport_id', $airport_id);
    }
        $flights = $flights->orderBy('id', 'DESC')
            ->paginate(5);


        $flights_data['flights'] = $flights;
        $data['body'] = view('flight.flight')->with($flights_data)->render();
        $data['flights'] = $flights->items();
        return $data;
    }

    public function ce_flight(Request $request)
    {
        $request->validate([
            'code' => ['required'],
        ]);

        $form_data = $request->all();

        $flight_id = $form_data['id'] ?? 0;
        if ($flight_id == 0) {
            Flight::create($request->all());
        } else {
            $flight_id = Flight::findOrFail($flight_id);
            $flight_id->update($request->all());
        }
        return response()->json(['success' => 'se actualizo con exito'], 201);
    }

    public function delete_flight(Request $request)
    {
        $flight_id = $request->input('flight_id');
        $flight = Flight::findOrFail($flight_id);
        $flight->update(['is_delete' => true]);
        return response()->json(['success' => "se elimino con exito"], 201);
    }

}
