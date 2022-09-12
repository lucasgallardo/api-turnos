<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller {

    public function pruebas(Request $request) {
        return "Acción de pruebas de USER-controller";
    }

    public function register(Request $request) {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        $params_array = array_map('trim', $params_array);

        if (!empty($params) && !empty($params_array)) {
            $validate = \Validator::make($params_array, [
                        'name' => 'required|alpha_num',
                        'surname' => 'required|alpha_num',
                        'email' => 'required|email|unique:users',
                        'password' => 'required'
            ]);

            if ($validate->fails()) {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El usuario no se ha creado correctamente',
                    'error' => $validate->errors()
                );
            } else {
                //cifrar contraseña
                $pwd = hash('sha256', $params->password);
                //crear usuario
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->email = $params_array['email'];
                $user->phone = $params_array['phone'];
                $user->password = $pwd;
                $user->role = 'ROLE_USER';

                //guardar usuario
                $user->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario creado correctamente',
                    'user' => $user
                );
            }
        } else {
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos enviados no son correctos o vacios',
                'error' => $validate->errors()
            );
        }
        return response()->json($data, $data['code']);
    }

    public function login(Request $request) {
        $jwtAuth = new \JwtAuth();

        //recibir datos por post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //validar esos datos
        $validate = \Validator::make($params_array, [
                    'email' => 'required|email',
                    'password' => 'required'
        ]);

        if ($validate->fails()) {
            $signup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'No se pudo identificar al usuario',
                'errors' => $validate->errors()
            );
        } else {
            //cifrar la contraseña
            $pwd = hash('sha256', $params->password);

            //devolver token o datos
            $signup = $jwtAuth->signup($params->email, $pwd);
            if (!empty($params->gettoken)) {
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }

        return response()->json($signup, 200);
    }

    public function update(Request $request) {
        //comprobar si el usuario está identificado
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        //recoger los datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if ($checkToken && !empty($params_array)) {
            //actualizar usuario
            //sacar usuario identificado
            $user = $jwtAuth->checkToken($token, true);

            //validar los datos
            $validate = \Validator::make($params_array, [
                        'name' => 'required|alpha',
                        'surname' => 'required|alpha',
                        'email' => 'required|email|unique:users,' . $user->sub
            ]);

            //quitar los campos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['role']);
            unset($params_array['password']);
            unset($params_array['created_at']);
            unset($params_array['remember_token']);

            //actualizar el usuario en bbdd
            $user_update = User::where('id', $user->sub)->update($params_array);

            //devolver array con el resultado
            $data = array(
                'code' => 200,
                'status' => 'success',
                'user' => $user,
                'changes' => $params_array
            );
        } else {
            //si no está identificado devolver mensaje de error
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'El usuario no está identificado'
            );
        }
        return response()->json($data, $data['code']);
    }

    public function upload(Request $request) {
        //recoger datos de la petición
        $image = $request->file('file0');

        //validacion de imagen
        $validate = \Validator::make($request->all(), [
                    'file0' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        //guardar imagen
        if (!$image || $validate->fails()) {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'message' => 'Error al subir imagen'
            );
        } else {
            $image_name = time() . $image->getClientOriginalName();
            \Storage::disk('users')->put($image_name, \File::get($image));

            $data = array(
                'code' => 200,
                'status' => 'success',
                'image' => $image_name
            );
        }
        return response()->json($data, $data['code']);
    }

    public function getImage($filename) {
        $isset = \Storage::disk('users')->exists($filename);
        if ($isset) {
            $file = \Storage::disk('users')->get($filename);
            return new Response($file, 200);
        } else {
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'La imagen no existe.'
            );

            return response()->json($data, $data['code']);
        }
    }
    
    public function detail($id){
        $user = User::find($id);
        
        if(is_object($user)){
            $data = array(
                'code' => 200,
                'status' => 'success',
                'user' => $user
            );
        }else{
            $data = array(
                'code' => 404,
                'status' => 'error',
                'message' => 'El usuario no existe'
            );
        }
        return response()->json($data, $data['code']);
    }

}
