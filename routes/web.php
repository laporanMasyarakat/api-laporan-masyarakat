<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//regis akun masyarakat
$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/users', 'AuthController@getUser');

//get user masyarakat

//akun petugas
$router->post('/petugas', 'PetugasController@createPetugas');
$router->get('/petugas', 'PetugasController@getPetugas');
$router->delete('/petugas/{id}', 'PetugasController@gdeletePetugas');

//pengaduan
$router->post('/pengaduan', 'PengaduanController@createPengaduan');
$router->get('/pengaduan',  'PengaduanController@getPengaduan');
$router->get('/pengaduan/{id}',  'PengaduanController@getPengaduanId');
$router->put('/updatepengaduan/{id}',  'PengaduanController@updateStatus');