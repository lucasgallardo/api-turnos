<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TipoDeVehiculo;

class TipoDeVehiculoController extends Controller {

    public function __construct() {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }

    public function index() {
        $tipos = TipoDeVehiculo::all();

        return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'type' => $tipos
        ]);
    }

    public function show($id) {
        $tipo = TipoDeVehiculo::find($id);

        if (is_object($tipo)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'type' => $tipo
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Tipo de vehiculo inexistente'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request) {
        //recoger los datos de post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            //validar los datos
            $validate = \Validator::make($params_array, [
                'name' => 'required'
            ]);

            //guardar la categoria
            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se guardo el tipo de vehiculo'
                ];
            } else {
                $tipo = new TipoDeVehiculo();
                $tipo->name = $params_array['name'];
                $tipo->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'type' => $tipo
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se recibieron datos de tipo de vehículo'
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
            $tipo = TipoDeVehiculo::where('id', $id)->update($params_array);

            $data = [
                'code' => 200,
                'status' => 'success',
                'type' => $params_array
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se envió datos sobre tipo de vehículo'
            ];
        }

        //devolver respuesta
        return response()->json($data, $data['code']);
    }

}
