<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../composer/vendor/autoload.php';
require_once '/clases/AccesoDatos.php';
require_once '/clases/userApi.php';
require_once '/clases/AutentificadorJWT.php';
require_once '/clases/MWparaCORS.php';
require_once '/clases/MWparaAutentificar.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*

¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);

//API REST LV
$app->group('/user', function () {
 
  $this->get('/', \userApi::class . ':traerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
 
  $this->get('/{id}', \userApi::class . ':TraerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

 $this->post('/', \userApi::class . ':CargarUno');

  $this->delete('/', \userApi::class . ':BorrarUno');

  $this->put('/', \userApi::class . ':ModificarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->run();