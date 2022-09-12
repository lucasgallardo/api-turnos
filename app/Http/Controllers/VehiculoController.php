<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Vehiculo;
use App\Helpers\JwtAuth;

class VehiculoController extends Controller {

    public function __construct() {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }

    public function index() {
        $vehiculos = Vehiculo::all()->load('user');

        return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'vehiculos' => $vehiculos
        ]);
    }

    public function show($id) {
        $vehiculo = Vehiculo::find($id);

        if (is_object($vehiculo)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'vehiculo' => $vehiculo
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Vehiculo inexistente'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request) {
        //recoger los datos de post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        
        if (!empty($params_array)) {

            //conseguir usuario identificado
            $user = $this->getIdentity($request);

            //validar los datos
            $validate = \Validator::make($params_array, [
                        'name' => 'required'
            ]);

            //guardar vehiculo
            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se guardo el vehiculo'
                ];
            } else {
                $vehiculo = new Vehiculo();
                $vehiculo->user_id = $user->sub;
                $vehiculo->name = $params_array['name'];
                $vehiculo->patente = $params_array['patente'];
                $vehiculo->anio = $params_array['anio'];
                $vehiculo->tipo = $params_array['tipo'];
                $vehiculo->detalles = $params_array['detalles'];                
                $vehiculo->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'vehiculo' => $vehiculo
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se recibieron datos de vehículo'
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
            $vehiculo = Vehiculo::where('id', $id)->update($params_array);

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
    
    public function getVehiculoByUser($user_id){
        $vehiculos = Vehiculo::where('user_id', $user_id)
                    ->get();

        if (is_object($vehiculos)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'vehiculos' => $vehiculos
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

    private function getIdentity($request) {
        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);

        return $user;
    }

}
