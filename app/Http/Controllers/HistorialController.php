<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JwtAuth;

class HistorialController extends Controller {

    public function __construct() {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }

    public function index() {
        $historial = \App\Models\Historial::all()->load('user');

        return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'Vehiculos' => $historial
        ]);
    }

    public function show($id) {
        $historial = Vehiculo::find($id);

        if (is_object($historial)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'vehiculo' => $historial
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Historial inexistente'
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
                        'name' => 'required',
                        'patente' => 'required'
            ]);

            //guardar la categoria
            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se guardo el historial'
                ];
            } else {
                $historial = new Vehiculo();
                $historial->user_id = $user->sub;
                $historial->name = $params_array['name'];
                $historial->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'vehiculo' => $historial
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se recibieron datos de historial'
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
            $historial = Historial::where('id', $id)->update($params_array);

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

    private function getIdentity($request) {
        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);

        return $user;
    }

}
