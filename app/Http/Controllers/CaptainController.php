<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Airplane;
use App\Models\Captain;
use App\Models\Flight;
use Illuminate\Http\Request;

class CaptainController extends Controller
{
    public function index(Request $request)
    {
        $data['flights'] = Flight::where('is_delete', false)->get();
        $data['captains'] = [];

        return view('captain.index')->with($data);
    }
//sadasdasd

    public function view_ce_captain(Request $request)
    {

        $flights = Flight::where('is_delete', false)->get();

        $captain_id = $request->input('captain_id') ?? 0;

        if ($captain_id == 0){

            $captain = new Captain();

        } else{
            $captain = Captain::findOrFail($captain_id);
        }


        $captain_data['captain'] = $captain ;
        $captain_data['flights'] = $flights;
        $data['body'] = view('captain.ce_captain')->with($captain_data)->render();
        return $data;
    }

    function get_captains(Request $request)
    {

        $search = $request->input('search') ?? '';
        $flight_id = $request->input('flight_id') ?? 0;

        $captains = Captain::where('is_delete', false);

        if ($search != ''){

//            $hairdresser = $hairdresser->where('name','like', "%$search%");

            $captains = $captains->where(function ($q) use ($search) {
                $q->where('name','like', "%$search%")
                    //faltaagregarfiltros

                ;
            });


        }

        if ($flight_id != 0){
            $captains = $captains->where('flight_id', $flight_id);
        }
        $captains = $captains->orderBy('id', 'DESC')
            ->paginate(5);

        $captains_data['captains'] = $captains;
        $data['body'] = view('captain.captain')->with($captains_data)->render();
        $data['captains'] = $captains->items();
        return $data;
    }

    public function ce_captain(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'flight_id' => ['required'],
        ]);

        $form_data = $request->all();

        $captain_id = $form_data['id'] ?? 0;
    //    $code = $form_data['code'] ?? [];

        if ($captain_id == 0 ) {
            $captain =  Captain::create($request->all());
        } else {
            $captain = Captain::findOrFail($captain_id);
            $captain->update($request->all());
        }

        $captain->save();

        return response()->json(['success' => 'se actualizo con exito'], 201);
    }

    public function delete_captain(Request $request)
    {
        $captain_id = $request->input('captain_id');
        $captain = Captain::findOrFail($captain_id);
        $captain->update(['is_delete' => true]);
        return response()->json(['success' => "se elimino con exito"], 201);
    }
}
