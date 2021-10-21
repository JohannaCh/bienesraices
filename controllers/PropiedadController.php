<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;


class PropiedadController{
    //utilizo stactic asi no necesito crear una nueva instancia
    public static function index(Router $router){ //con Router $router mantiene la referencia al mismo objeto que definimos en el archivo index - o sea le pasamos el mismo objeto
        
        
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        
         //muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null; // revisa si hay un get con el valor de resultado, de lo contrario le asigna null
        
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router){

        $propiedad = new Propiedad; //creo una nueva instancia con un objeto vacio
        $vendedores = Vendedor::all(); //traigo a todos los vendedores para que se muestre en el formulario

         //arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            //instanciando una nueva propiedad
        $propiedad = new Propiedad($_POST['propiedad']);

        // Generar nombre unico
        $nombreImagen = md5( uniqid( rand(), true ) ).".jpg";

        //setear la imagen

        //Realiza una resize a la imagen con intervention
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImage($nombreImagen);
        }

        //validamos
        $errores = $propiedad->validar();
        
        // Revisar que el arreglo de errores este vacio
        if (empty($errores)) {
            
            if (!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }
            
            // Guarda la imagen en el servidor
            $image->save(CARPETA_IMAGENES.$nombreImagen);
            
            $propiedad->guardar();
            
        }
        }

        $router->render('propiedades/crear', [ //mando a llamar render con el contenido que deseo
            'propiedad' => $propiedad, //propiedad es igual a propiedad
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin'); 
        $propiedad = Propiedad::find($id); //uso el modelo importado con el metodo find para buscar el id
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores(); //declaro el array de errores y llamo al metodo para obtener las alertas

        //Metodo POST para actualizar
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            //asignar los atributos
            $args = $_POST['propiedad']; //lleemos el post
    
            $propiedad->sincronizar($args); //sincronizamos con active record
    
    
            //validacion
            $errores = $propiedad->validar();
    
            //subida de archivos
    
            // Generar nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ).".jpg";
    
            
            //Realiza una resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImage($nombreImagen);
            }
    
    
            // Revisar que el arreglo de errores este vacio
            if (empty($errores)) {
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    //almacenar la imagen
                    $image->save(CARPETA_IMAGENES.$nombreImagen);
                }
                $propiedad->guardar();
            }
    
    
        }

        $router->render('/propiedades/actualizar', [//llamo a render para la vista
            'propiedad' => $propiedad,   //paso las propiedades a la vista
            'errores' => $errores, //paso los errores a la vista
            'vendedores' =>$vendedores //paso los vendedores a la vista
        ]); 
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        //validar id
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT); //toma el id y el filtro con el cual validar, en este caso que sea int

            if ($id) {

                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id); //Busca la propiedad por el id
                    $propiedad->eliminar(); //la elimina
                }
            }
        }
    }

}