<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Servicios;

class ServiciosController extends Controller {

    public function __construct() {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }

    public function index() {
        $servicios = Servicios::all();

        return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'servicios' => $servicios
        ]);
    }

    public function show($id) {
        $servicio = Servicios::find($id);

        if (is_object($servicio)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'servicio' => $servicio
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Servicio inexistente'
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
                        'name' => 'required',
                        'duration' => 'required'
            ]);

            //guardar la categoria
            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se guardo el servicio',
                    'error' => $validate->errors()
                ];
            } else {
                $servicio = new Servicios();
                $servicio->name = $params_array['name'];
                $servicio->type = $params_array['type'];
                $servicio->duration = $params_array['duration'];
                $servicio->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'servicio' => $servicio
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se recibieron datos de servicio'
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
            
            unset($params_array['id']);
            unset($params_array['created_at']);

            //actualizar el registro
            $servicio = Servicios::where('id', $id)->update($params_array);

            $data = [
                'code' => 200,
                'status' => 'success',
                'servicio' => $params_array
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se envió datos sobre servicio'
            ];
        }

        //devolver respuesta
        return response()->json($data, $data['code']);
    }

}
