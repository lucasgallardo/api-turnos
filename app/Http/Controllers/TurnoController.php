<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Turno;
use App\Helpers\JwtAuth;

class TurnoController extends Controller {

    public function __construct() {
        $this->middleware('api.auth', ['except' => ['index', 'show', 'getTurnoByDate']]);
    }

    public function index() {
        $turnos = Turno::all()->load('user')
                ->load('vehiculo')
                ->load('servicio');

        return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'Vehiculos' => $turnos
        ]);
    }

    public function show($id) {
        $turno = Turno::find($id)->load('user')
                ->load('vehiculo')
                ->load('servicio');

        if (is_object($turno)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'turno' => $turno
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Turno inexistente'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request) {
        //recoger los datos de post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        $today = date('Y-m-d');

        if (!empty($params_array)) {

            //conseguir usuario identificado
            $user = $this->getIdentity($request);

            //validar los datos
            $validate = \Validator::make($params_array, [
                        'vehiculo_id' => 'required',
                        'servicio_id' => 'required',
                        'dia' => 'required|after_or_equal:' . $today
            ]);

            //guardar la categoria
            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se guardó el turno',
                    'error' => $validate->errors()
                ];
            } else {
                $turno = new Turno();
                $turno->user_id = $user->sub;
                $turno->vehiculo_id = $params_array['vehiculo_id'];
                $turno->servicio_id = $params_array['servicio_id'];
                $turno->sucursal = '1';
                $turno->detalle = $params_array['detalle'];
                $turno->dia = $params_array['dia'];
                $turno->hora = $params_array['hora'];
                $turno->duracion = $params_array['duracion'];
                $turno->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'turno' => $turno
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se recibieron datos de turno'
            ];
        }

        //devolver el resultado
        return response()->json($data, $data['code']);
    }

    //guardar turno de tercero
    public function store_external(Request $request) {
        //recoger los datos de post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            //conseguir usuario identificado
            $user = $this->getIdentity($request);

            //validar los datos
            $validate = \Validator::make($params_array, [
                        'vehiculo_id' => 'required',
                        'servicio_id' => 'required',
                        'user_id' => 'required'
            ]);

            //guardar la categoria
            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se guardo el vehiculo'
                ];
            } else {
                $turno = new Vehiculo();
                $turno->user_id = $params_array['user_id'];
                $turno->vehiculo_id = $params_array['vehiculo_id'];
                $turno->servicio_id = $params_array['servicio_id'];
                $turno->sucursal = '1';
                $turno->detalle = $params_array['detalles'];
                $turno->dia = $params_array['dia'];
                $turno->hora = $params_array['hora'];
                $turno->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'turno' => $turno
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se recibieron datos del turno'
            ];
        }

        //devolver el resultado
        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request) {
        //recoger los datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            //validar los datos
            $validate = \Validator::make($params_array, [
                        'name' => 'required'
            ]);

            //quitar lo que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro (categoria)
            $turno = Turno::where('id', $id)->update($params_array);

            $data = [
                'code' => 200,
                'status' => 'success',
                'vehiculo' => $params_array
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se envió datos sobre vehículo'
            ];
        }

        //devolver respuesta
        return response()->json($data, $data['code']);
    }

    public function getTurnoByUser($user_id) {
        $turno = Turno::where('user_id', $user_id)
                    ->get()
                    ->load('user')
                    ->load('vehiculo')
                    ->load('servicio');

        if (is_object($turno)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'turno' => $turno
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Usuario inexistente'
            ];
        }

        return response()->json($data, $data['code']);
    }
    
    public function getTurnoByDate($date) {
        $today = date('Y-m-d');
                        
        $turno = Turno::where('dia', $date)                    
                    ->get()
                    ->load('user')
                    ->load('vehiculo')
                    ->load('servicio');

        if (is_object($turno)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'turno' => $turno
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Usuario inexistente'
            ];
        }

        return response()->json($data, $data['code']);
    }
    
    public function getTurnoByUserByDate($date, Request $request) {
        $today = date('Y-m-d');
        $user = $this->getIdentity($request);
        
        $turno = Turno::all()->load('user')
                ->where('dia', '>=' , $date)
                ->load('vehiculo')
                ->load('servicio');
        
        if (is_object($turno)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'turno' => $turno
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Usuario inexistente'
            ];
        }

        return response()->json($data, $data['code']);
    }
    
    //metodo de borrado para el cliente    
    public function destroy($id, Request $request) {
        //conseguir usuario identificado
        $user = $this->getIdentity($request);

        //conseguir el registro
        $turno = Turno::where('id', $id)
                ->where('user_id', $user->sub)
                ->first();

        if (!empty($turno)) {

            //borrarlo
            $turno->delete();

            //devolver algo
            $data = [
                'code' => 200,
                'status' => 'success',
                'post' => $turno
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'El turno no existe'
            ];
        }

        return response()->json($data, $data['code']);
    }
    
    //metodo de borrado para el cliente    
    public function destroyAdmin($id) {
        //conseguir el registro
        $turno = Turno::where('id', $id)
                ->first();

        if (!empty($turno)) {

            //borrarlo
            $turno->delete();

            //devolver algo
            $data = [
                'code' => 200,
                'status' => 'success',
                'post' => $turno
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'El turno no existe'
            ];
        }

        return response()->json($data, $data['code']);
    }


    private function getIdentity($request) {
        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);

        return $user;
    }

}
