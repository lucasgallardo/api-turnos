--------+-----------+------------------------------------------+------------------------+--------------------------------------------------------+---------------------------------------+
| Domain | Method    | URI                                      | Name                   | Action                                                 | Middleware                            |
+--------+-----------+------------------------------------------+------------------------+--------------------------------------------------------+---------------------------------------+
|        | GET|HEAD  | /                                        |                        | Closure                                                | web                                   |
|        | POST      | api/login                                |                        | App\Http\Controllers\UserController@login              | web                                   |
|        | GET|HEAD  | api/marca                                | marca.index            | App\Http\Controllers\MarcaController@index             | web                                   |
|        | POST      | api/marca                                | marca.store            | App\Http\Controllers\MarcaController@store             | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/marca/create                         | marca.create           | App\Http\Controllers\MarcaController@create            | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | DELETE    | api/marca/{marca}                        | marca.destroy          | App\Http\Controllers\MarcaController@destroy           | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | PUT|PATCH | api/marca/{marca}                        | marca.update           | App\Http\Controllers\MarcaController@update            | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/marca/{marca}                        | marca.show             | App\Http\Controllers\MarcaController@show              | web                                   |
|        | GET|HEAD  | api/marca/{marca}/edit                   | marca.edit             | App\Http\Controllers\MarcaController@edit              | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | POST      | api/modelo                               | modelo.store           | App\Http\Controllers\ModeloController@store            | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/modelo                               | modelo.index           | App\Http\Controllers\ModeloController@index            | web                                   |
|        | GET|HEAD  | api/modelo/create                        | modelo.create          | App\Http\Controllers\ModeloController@create           | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/modelo/marca/{id}                    |                        | App\Http\Controllers\ModeloController@getModeloByMarca | web                                   |
|        | GET|HEAD  | api/modelo/{modelo}                      | modelo.show            | App\Http\Controllers\ModeloController@show             | web                                   |
|        | DELETE    | api/modelo/{modelo}                      | modelo.destroy         | App\Http\Controllers\ModeloController@destroy          | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | PUT|PATCH | api/modelo/{modelo}                      | modelo.update          | App\Http\Controllers\ModeloController@update           | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/modelo/{modelo}/edit                 | modelo.edit            | App\Http\Controllers\ModeloController@edit             | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | POST      | api/register                             |                        | App\Http\Controllers\UserController@register           | web                                   |
|        | POST      | api/servicios                            | servicios.store        | App\Http\Controllers\ServiciosController@store         | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/servicios                            | servicios.index        | App\Http\Controllers\ServiciosController@index         | web                                   |
|        | GET|HEAD  | api/servicios/create                     | servicios.create       | App\Http\Controllers\ServiciosController@create        | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/servicios/{servicio}                 | servicios.show         | App\Http\Controllers\ServiciosController@show          | web                                   |
|        | DELETE    | api/servicios/{servicio}                 | servicios.destroy      | App\Http\Controllers\ServiciosController@destroy       | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | PUT|PATCH | api/servicios/{servicio}                 | servicios.update       | App\Http\Controllers\ServiciosController@update        | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/servicios/{servicio}/edit            | servicios.edit         | App\Http\Controllers\ServiciosController@edit          | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/tipoDeVehiculo                       | tipoDeVehiculo.index   | App\Http\Controllers\TipoDeVehiculoController@index    | web                                   |
|        | POST      | api/tipoDeVehiculo                       | tipoDeVehiculo.store   | App\Http\Controllers\TipoDeVehiculoController@store    | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/tipoDeVehiculo/create                | tipoDeVehiculo.create  | App\Http\Controllers\TipoDeVehiculoController@create   | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | PUT|PATCH | api/tipoDeVehiculo/{tipoDeVehiculo}      | tipoDeVehiculo.update  | App\Http\Controllers\TipoDeVehiculoController@update   | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/tipoDeVehiculo/{tipoDeVehiculo}      | tipoDeVehiculo.show    | App\Http\Controllers\TipoDeVehiculoController@show     | web                                   |
|        | DELETE    | api/tipoDeVehiculo/{tipoDeVehiculo}      | tipoDeVehiculo.destroy | App\Http\Controllers\TipoDeVehiculoController@destroy  | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/tipoDeVehiculo/{tipoDeVehiculo}/edit | tipoDeVehiculo.edit    | App\Http\Controllers\TipoDeVehiculoController@edit     | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/turno                                | turno.index            | App\Http\Controllers\TurnoController@index             | web                                   |
|        | POST      | api/turno                                | turno.store            | App\Http\Controllers\TurnoController@store             | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/turno/create                         | turno.create           | App\Http\Controllers\TurnoController@create            | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/turno/user/{id}                      |                        | App\Http\Controllers\TurnoController@getTurnoByUser    | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | DELETE    | api/turno/{turno}                        | turno.destroy          | App\Http\Controllers\TurnoController@destroy           | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | PUT|PATCH | api/turno/{turno}                        | turno.update           | App\Http\Controllers\TurnoController@update            | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/turno/{turno}                        | turno.show             | App\Http\Controllers\TurnoController@show              | web                                   |
|        | GET|HEAD  | api/turno/{turno}/edit                   | turno.edit             | App\Http\Controllers\TurnoController@edit              | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/user                                 |                        | Closure                                                | api                                   |
|        |           |                                          |                        |                                                        | auth:api                              |
|        | GET|HEAD  | api/user/avatar/{filename}               |                        | App\Http\Controllers\UserController@getImage           | web                                   |
|        | GET|HEAD  | api/user/detail/{id}                     |                        | App\Http\Controllers\UserController@detail             | web                                   |
|        | PUT       | api/user/update                          |                        | App\Http\Controllers\UserController@update             | web                                   |
|        | POST      | api/user/upload                          |                        | App\Http\Controllers\UserController@upload             | web                                   |
|        |           |                                          |                        |                                                        | App\Http\Middleware\ApiAuthMiddleware |
|        | POST      | api/vehiculo                             | vehiculo.store         | App\Http\Controllers\VehiculoController@store          | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/vehiculo                             | vehiculo.index         | App\Http\Controllers\VehiculoController@index          | web                                   |
|        | GET|HEAD  | api/vehiculo/create                      | vehiculo.create        | App\Http\Controllers\VehiculoController@create         | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | PUT|PATCH | api/vehiculo/{vehiculo}                  | vehiculo.update        | App\Http\Controllers\VehiculoController@update         | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/vehiculo/{vehiculo}                  | vehiculo.show          | App\Http\Controllers\VehiculoController@show           | web                                   |
|        | DELETE    | api/vehiculo/{vehiculo}                  | vehiculo.destroy       | App\Http\Controllers\VehiculoController@destroy        | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | api/vehiculo/{vehiculo}/edit             | vehiculo.edit          | App\Http\Controllers\VehiculoController@edit           | web                                   |
|        |           |                                          |                        |                                                        | api.auth                              |
|        | GET|HEAD  | pruebas/{nombre?}                        |                        | Closure                                                | web                                   |
+--------+-----------+------------------------------------------+------------------------+--------------------------------------------------------+---------------------------------------+
