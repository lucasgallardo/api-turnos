<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Modelo;

class ModeloController extends Controller {

    public function __construct() {
        $this->middleware('api.auth', ['except' => ['index', 'show', 'getModeloByMarca']]);
    }

    public function index() {
        $modelos = Modelo::all()->load('marca');

        return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'modelos' => $modelos
        ]);
    }

    public function show($id) {
        $modelo = Modelo::find($id);

        if (is_object($modelo)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'modelo' => $modelo
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Modelo inexistente'
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

            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se guardo el modelo'
                ];
            } else {
                $modelo = new Modelo();
                $modelo->name = $params_array['name'];
                $modelo->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'modelo' => $modelo
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se recibieron datos de modelo de vehículo'
            ];
        }

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
            $modelo = Modelo::where('id', $id)->update($params_array);

            $data = [
                'code' => 200,
                'status' => 'success',
                'modelo' => $params_array
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se envió datos sobre modelo de vehículo'
            ];
        }

        //devolver respuesta
        return response()->json($data, $data['code']);
    }

    public function getModeloByMarca($id_marca) {
        $modelos = Modelo::where('marca_id', $id_marca)->get()->load('marca');

        if (is_object($modelos)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'modelos' => $modelos
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Modelo inexistente'
            ];
        }

        return response()->json($data, $data['code']);
    }

}
