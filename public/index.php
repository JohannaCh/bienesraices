<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\PaginasController;
use Controllers\VendedorController;
use Controllers\PropiedadController;

$router = new Router;

//ZONA PRIVADA
$router->get('/admin', [PropiedadController::class, 'index']); //PropiedadController::class trae el namespace donde esta esa funcion
$router->get('/propiedades/crear', [PropiedadController::class, 'crear'] );
$router->post('/propiedades/crear', [PropiedadController::class, 'crear'] );
$router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar'] );
$router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar'] );
$router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar'] );

$router->get('/vendedores/crear', [VendedorController::class, 'crear'] );
$router->post('/vendedores/crear', [VendedorController::class, 'crear'] );
$router->get('/vendedores/actualizar', [VendedorController::class, 'actualizar'] );
$router->post('/vendedores/actualizar', [VendedorController::class, 'actualizar'] );
$router->post('/vendedores/eliminar', [VendedorController::class, 'eliminar'] );


// ZONA PÙBLICA
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/propiedades', [PaginasController::class, 'propiedades']);
$router->get('/propiedad', [PaginasController::class, 'propiedad']);
$router->get('/blog', [PaginasController::class, 'blog']);
$router->get('/entrada', [PaginasController::class, 'entrada']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);

// Login y autenticacion
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);


$router->comprobarRutas();
