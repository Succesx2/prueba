<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index(Request $request)
    {
        $data['airports'] = Airport::where('is_delete', false)->get();
        $data['airlines'] = [];

        return view('airline.index')->with($data);
    }

    public function view_ce_airline(Request $request)
    {

        $airports = Airport::where('is_delete', false)->get();

        $airline_id = $request->input('airline_id') ?? 0;

        if ($airline_id == 0){

            $airline = new Airline();

        } else{
            $airline = Airline::findOrFail($airline_id);
        }


        $airline_data['airline'] = $airline;
        $airline_data['airports'] = $airports;
        $data['body'] = view('airline.ce_airline')->with($airline_data)->render();
        return $data;
    }

    function get_airlines(Request $request)
    {
        $search = $request->input('search') ?? '';
        $airport_id = $request->input('airport_id') ?? 0;

        $airlines = Airline::where('is_delete', false);

        if ($search != ''){

            $airlines = $airlines->where(function ($q) use ($search) {
                $q->where('name','like', "%$search%")
                ;
            });


        }
        if ($airport_id != 0){
            $airlines = $airlines->where('airport_id', $airport_id);
        }
        $airlines = $airlines->orderBy('id', 'DESC')
            ->paginate(5);


        $airlines_data['airlines'] = $airlines;
        $data['body'] = view('airline.airline')->with($airlines_data)->render();
        $data['airlines'] = $airlines->items();
        return $data;
    }

    public function ce_airline(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'airport_id' => ['required'],
        ]);

        $form_data = $request->all();

        $airline_id = $form_data['id'] ?? 0;
        if ($airline_id == 0) {
            Airline::create($request->all());
        } else {
            $airline_id = Airline::findOrFail($airline_id);
            $airline_id->update($request->all());
        }
        return response()->json(['success' => 'se actualizo con exito'], 201);
    }

    public function delete_airline(Request $request)
    {
        $airline_id = $request->input('airline_id');
        $airline = Airline::findOrFail($airline_id);
        $airline->update(['is_delete' => true]);
        return response()->json(['success' => "se elimino con exito"], 201);
    }

    public function restore_airline(Request $request)
    {
        $airline_id = $request->input('airline_id');
        $airline = Airline::findOrFail($airline_id);
        $airline->update(['is_delete' => false]);
        return response()->json(['success' => "se restauro con exito"], 201);
    }
}
