<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class UserAPI extends Controller
{
    // Lista los Usuarios
    public function Show()
    {
        // try{
            $user = DB::table('user')
                ->select('*')
                ->where('status', '=', '1')
                ->orderBy('id_user')
                ->get();
            $response = Response::json($user,200);
            return $response;
            
        //}catch(\Exception $e){
            Log::critical("La solicitud no puede ser procesada: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response()->json(['status' => 'false', 'message' => 'No es posible mostrar los usuarios ahora' ],500);
        //}
    }

    // Crea los Usurios
    public function create(Request $request)
    {
        try{
            $data = $request->all();
            $user = new User([
            'user_name' => $data['user_name'],
            'user_lastName' => $data['user_lastName'],
            'date_created' => date('Y-m-d H:i:s'),
            'date_update' => date('Y-m-d H:i:s'),
            'id_role' => $data['id_role'],
            'user_password' => $data['user_password'],
            'user_email' => $data['user_email'],
            'status' => 1,
            ]);
            $user -> save();
            $response = Response::json(['status' => 'true', 'message' => 'El usuario fue creado con éxito'], 200);
            return $response;

        }catch(\Exception $e){
            Log::critical("La solicitud no puede ser procesada: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response()->json(['status' => 'false', 'message' => 'No es posible crear el usuario ahora' ],500);   
        }
    }

    // Editar la Capasitación
    public function update(Request $request)
    {
        try{
            $data = $request->all();
            $user = User::find($data['id_user']);
            if(!$user){
                return response() -> json(['Status' => 'false', 'Message' => 'El usuario no existe'],200);
            }else{
                $user -> user_name = $data['user_name'];
                $user -> user_lastName = $data['user_lastName'];
                $user -> date_update = date('Y-m-d H:i:s');
                if ($data['user_password']){ $user -> user_password = $data['user_password'];};
                $user -> save();

                return response()->json(['Status' => 'true', 'Message' => 'Usuario editado exitosamente'],200);
            }
        }catch(\Exception $e){
            Log::critical("La solicitud no puede ser procesada: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response()->json(['status' => 'false', 'message' => 'No es posible editar el usuario ahora'],500);
        }
    }

    // Eliminar la Capasitación
    public function delete(Request $request)
    {
        try{
        $data = $request->all();
        $user = User::find($data['id_training']);
        if(!$user){
            return response() -> json(['Status' => 'false', 'Message' => 'El usuario no existe'],200);
        }else{
            $user -> status = 0;
            $user -> save();
    
            return response()->json(['Status' => 'true', 'Message' => 'El usuario se eliminó exitosamente'],200);
        }
        }catch(\Exception $e){
            Log::critical("La solicitud no puede ser procesada: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response()->json(['status' => 'false', 'message' => 'No es posible eliminar el usuario ahora' ],500);
        }
    }

    // Login
    public function login (Request $request)
    {
        $data = $request->all();
        $user_name = $data['user_nickName'];
        $user_password = $data['user_password'];
        $user = DB::table('user')
            ->select('*')
            ->where([['user_nickName', '=',$user_name],['status', '=', '1']])
            ->first();
        if(!$user){
            return response()->json(['status' => 'false', 'Message' => 'El usuario no se encuentra registrado en el sistema'], 200);
        
        }else {  
            $password = $user -> user_password;

            // Verifica la ultima actualizaciond de la contraseña
            $datetime1 = new DateTime($user -> date_update);
            $datetime2 = new DateTime(date('Y-m-d'));
            $interval = date_diff($datetime1, $datetime2);
            $interval->format('%R%a días');

            if($password == $user_password){
                if($interval -> d >= 60 or $interval -> m >= 2){

                    return response()->json(['status' => 'false', 'Message' => 'Por favor actualice su contraseña'], 200);
                }
                return response()->json(['user' => $user, 'status' => 'true'], 200);
            
            }else{

                return response()->json(['status' => 'false', 'Message' => 'Contraseña incorrecta'], 200);
            }
        }
    }
}