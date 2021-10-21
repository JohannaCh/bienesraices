<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController{

    public static function crear( Router $router){ //importo el objeto que instancie en index

        $errores = Vendedor::getErrores(); //traemos el array de errores
        $vendedor = new Vendedor; //instancio un objeto vacio y lo paso al render 

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            //crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']); //entra  a la clase vendedor y se crea el constructor
    
            //validar que no haya campos vacios
            $errores = $vendedor->validar(); //coloca en el array errores los avisos que encontro
    
    
            // en caso que no haya errores
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }    

        $router->render('/vendedores/crear', [ //llamo al render que genera la vista y le digo cual vista y luego le paso los datos de la vista en un arreglo
            'errores' =>$errores, //pasamos los errores a la vista
            'vendedor'  =>$vendedor
        ]); 
        
            
        }


    public static function actualizar(Router $router){  //Le paso el objeto instanciado en index
        
        $errores = Vendedor::getErrores(); //llamo al array errores de la clase vendedores para mostrar las alertas que correspondan
        $id = validarORedireccionar('/admin'); //compruebo si obtuve un id valido de lo contrario lo redirecciono a admin

        //obtener datos del vendedor a actualizar
        $vendedor = Vendedor::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            //asignar los valores
            $args = $_POST['vendedor'];
    
            $vendedor->sincronizar($args); //sincronizamo el objeto en memoria con lo que el usuario escribio
    
            //validacion para ver que todos los datos esten correctos
            $errores = $vendedor->validar();
    
            if (empty($errores)) { //en caso que errores este vacio
                $vendedor->guardar(); 
            }
        }

        $router->render('vendedores/actualizar',[ //le paso la vista al render
            'errores' =>$errores,
            'vendedor' =>$vendedor
        ]);
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //valida el id
            $id = $_POST['id']; //a $id le coloca el id de post
            $id = filter_var($id, FILTER_VALIDATE_INT); //le pasamos el id y luego el filtro que vamos a utilizar
            
            if ($id) {
        
            $tipo = $_POST['tipo']; //asignamos el tipo de post a $tipo

                if (validarTipoContenido($tipo)) { //validamos el tipo
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }

        }
    }
}