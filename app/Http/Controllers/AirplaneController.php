<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Airplane;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirplaneController extends Controller
{
    public function index(Request $request)
    {
        $data['airlines'] = Airline::where('is_delete', false)->get();
        $data['airplanes'] = [];

        return view('airplane.index')->with($data);
    }
//sadasdasd

    public function view_ce_airplane(Request $request)
    {

        $airlines = Airline::where('is_delete', false)->get();

        $airplane_id = $request->input('airplane_id') ?? 0;

        $random_code = "cod-" . str_random(4);

        if ($airplane_id == 0){

            $airplane = new Airplane();
            $airplane->code = 'cod-'. str_random(4);
        } else{
            $airplane = Airplane::findOrFail($airplane_id);
        }


        $airplane_data['airplane'] = $airplane;
        $airplane_data['airlines'] = $airlines;
        $airplane_data['random_code'] = $random_code;
        $data['body'] = view('airplane.ce_airplane')->with($airplane_data)->render();
        return $data;
    }

    function get_airplanes(Request $request)
    {

        $search = $request->input('search') ?? '';
        $airline_id = $request->input('airline_id') ?? 0;

        $airplanes = Airplane::where('is_delete', false);

        if ($search != ''){

//            $hairdresser = $hairdresser->where('name','like', "%$search%");

            $airplanes = $airplanes->where(function ($q) use ($search) {
                $q->where('name','like', "%$search%")
                    //faltaagregarfiltros

                ;
            });


        }

        if ($airline_id != 0){
            $airplanes = $airplanes->where('airline_id', $airline_id);
        }
        $airplanes = $airplanes->orderBy('id', 'DESC')
            ->paginate(5);

        $airplanes_data['airplanes'] = $airplanes;
        $data['body'] = view('Airplane.airplane')->with($airplanes_data)->render();
        $data['airplanes'] = $airplanes->items();
        return $data;
    }

    public function ce_airplane(Request $request)
    {
        $request->validate([
            'code' => ['required'],
            'airline_id' => ['required'],
            'create_date' => ['required'],
            'next_maintenance' => ['required'],
        ]);

        $form_data = $request->all();

        $airplane_id = $form_data['id'] ?? 0;
        $code = $form_data['code'] ?? [];

        if ($airplane_id == 0 ) {
            $airplane =  Airplane::create($request->all());
            $airplane->code = 'COD-'. str_random(4);
        } else {
            $airplane = Airplane::findOrFail($airplane_id);
            $airplane->update($request->all());
        }

        $airplane->save();

        return response()->json(['success' => 'se actualizo con exito'], 201);
    }

    public function delete_airplane(Request $request)
    {
        $airplane_id = $request->input('airplane_id');
        $airplane = Airplane::findOrFail($airplane_id);
        $airplane->update(['is_delete' => true]);
        return response()->json(['success' => "se elimino con exito"], 201);
    }
}
