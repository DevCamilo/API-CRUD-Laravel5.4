<?php

namespace App\Http\Controllers;

use App\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class TrainingAPI extends Controller
{
    // Lista las Capasitaciones
    public function show() 
    {
        try{
        $training = DB::table('training')
            ->select('training_name', 'training_description', 'id_training', 'training_status')
            ->where('training_status', '=', '1')
            ->get();
        $response = Response::json($training,200);
        return $response;
        
        }catch(\Exception $e){
            Log::critical("La solicitud no puede ser procesada: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response()->json(['status' => false, 'message' => 'No es posible mostrar las capacitaciones ahora' ],500);
        }
    }

    // Crea la Capasitacion
    public function create(Request $request)
    {
        try{
        $data = $request->all();
        $training = new Training([
            'training_name' => $data["training_name"], 
            'training_description' => $data["training_description"],
            'id_training_group' => $data["id_training_group"],
            'training_status' => 1,    
        ]);
        $training -> save();
        $response = Response::json(['status' => true, 'message' => 'La capacitación fue creada con éxito'], 200);
        return $response;

        }catch(\Exception $e){
            Log::critical("La solicitud no puede ser procesada: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response()->json(['status' => false, 'message' => 'No es posible crear la capacitación ahora' ],500);
        }
    }

    // Editar la Capasitación
    public function update(Request $request)
    {
        try{
            $data = $request->all();
            $training = Training::find($data['id_training']);
            if(!$training){
                return response() -> json(['Status' => 'false', 'Message' => 'La capasitacion no existe'],200);
            }else{
                $training -> training_name = $data["training_name"];
                $training -> training_description = $data["training_description"];
                $training -> save();

                return response()->json(['Status' => 'true', 'Message' => 'Capasitacion editada exitosamente'],200);
            }
        }catch(\Exception $e){
            Log::critical("La solicitud no puede ser procesada: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response()->json(['status' => false, 'message' => 'No es posible actualizar la capacitacion ahora' ],500);
        }
    }

    // Eliminar la Capasitación
    public function delete(Request $request)
    {
        try{
        $data = $request->all();
        $training = Training::find($data['id_training']);
        if(!$training){
            return response() -> json(['Status' => 'false', 'Message' => 'La capasitacion no existe'],200);
        }else{
            $training -> training_status = 0;
            $training -> save();

            return response()->json(['Status' => 'true', 'Message' => 'Capasitacion eliminada exitosamente'],200);
        }
        }catch(\Exception $e){
            Log::critical("La solicitud no puede ser procesada: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response()->json(['status' => false, 'message' => 'No es posible eliminar la capacitacion ahora' ],500);
        }
    }
}
