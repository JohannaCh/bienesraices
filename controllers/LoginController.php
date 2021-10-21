<?php

namespace Controllers; //le asigno su etiqueta 
use MVC\Router;
use Model\Admin; //importo los modelos

class LoginController{

    public static function login(Router $router){ //le paso el objeto router
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST); //creamos una nueva instancia con lo que contenga post

            $errores = $auth->validar(); //toma los datos de auth, los valida y el resultado lo asigna a errores

            if (empty($errores)) {
                //verificar si el usuario existe
                $resultado = $auth->existeUsuario(); //en caso de que no exista simplemente queda como null la variable

                if (!$resultado) {
                    //verificar si el usuario existe o no (mensaje de error)
                   $errores = Admin::getErrores(); //asi obtiene los errores que se crearon en la clase Admin
                }else{
                    //verificar el password
                    $autenticado = $auth->comprobarPassword($resultado); //a esta altura ya existe y tiene un valor por lo tanto lo pasamos a la funcion
                
                    if ($autenticado) {
                        //autenticar al usuario
                        $auth->autenticar(); // llamo a un metodo de la clase para no cargar de codigo el controlador
                        
                    }else{
                        $errores = Admin::getErrores(); //asi obtiene los errores que se crearon en la clase Admin
                    }
                }

            }
        }
        
        $router->render('auth/login', [ //asi me permite usar unas de sus funciones llamada render
            'errores'=>$errores
        ]);
    }

    public static function logout(){
        session_start();

        $_SESSION = []; //limpiamos el arreglo session

        header('Location: /'); //redireccionamos a la pagina principal
    }

}