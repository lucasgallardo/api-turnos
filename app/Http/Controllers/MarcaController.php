<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }

    public function index() {
        $marca = Marca::all()->load('tipo_vehiculo');

        return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'marcas' => $marca
        ]);
    }

    public function show($id) {
        $marca = Marca::find($id);

        if (is_object($marca)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'marca' => $marca
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Marca inexistente'
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
                    'message' => 'No se guardo la marca'
                ];
            } else {
                $marca = new Marca();
                $marca->name = $params_array['name'];
                $marca->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'marca' => $marca
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se recibieron datos de marca'
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
            $marca = Marca::where('id', $id)->update($params_array);

            $data = [
                'code' => 200,
                'status' => 'success',
                'marca' => $params_array
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se envió datos sobre marca'
            ];
        }

        //devolver respuesta
        return response()->json($data, $data['code']);
    }
}
