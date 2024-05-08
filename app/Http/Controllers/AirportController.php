<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Country;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index(Request $request)
    {
        $data['countries'] = Country::where('is_delete', false)->get();
        $data['airports'] = [];

        return view('airport.index')->with($data);
    }

    public function view_ce_airport(Request $request)
    {

        $countries = Country::where('is_delete', false)->get();

        $airport_id = $request->input('airport_id') ?? 0;

        if ($airport_id == 0){

            $airport = new Airport();

        } else{
            $airport = Airport::findOrFail($airport_id);
        }


        $airport_data['airport'] = $airport;
        $airport_data['countries'] = $countries;
        $data['body'] = view('airport.ce_airport')->with($airport_data)->render();
        return $data;
    }

    function get_airports(Request $request)
    {
        $search = $request->input('search') ?? '';
        $country_id = $request->input('country_id') ?? 0;

        $airports = Airport::where('is_delete', false);

        if ($search != ''){

            $airports = $airports->where(function ($q) use ($search) {
                $q->where('name','like', "%$search%")
                ;
            });


        }
        if ($country_id != 0){
            $airports = $airports->where('country_id', $country_id);
        }
        $airports = $airports->orderBy('id', 'DESC')
            ->paginate(5);


        $airports_data['airports'] = $airports;
        $data['body'] = view('airport.airport')->with($airports_data)->render();
        $data['airports'] = $airports->items();
        return $data;
    }

    public function ce_airport(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'country_id' => ['required'],
        ]);

        $form_data = $request->all();

        $airport_id = $form_data['id'] ?? 0;
        if ($airport_id == 0) {
            Airport::create($request->all());
        } else {
            $airport_id = Airport::findOrFail($airport_id);
            $airport_id->update($request->all());
        }
        return response()->json(['success' => 'se actualizo con exito'], 201);
    }

    public function delete_airport(Request $request)
    {
        $airport_id = $request->input('airport_id');
        $airport = Airport::findOrFail($airport_id);
        $airport->update(['is_delete' => true]);
        return response()->json(['success' => "se elimino con exito"], 201);
    }

    public function restore_airport(Request $request)
    {
        $airport_id = $request->input('airport_id');
        $airport = Airport::findOrFail($airport_id);
        $airport->update(['is_delete' => false]);
        return response()->json(['success' => "se restauro con exito"], 201);
    }



}
