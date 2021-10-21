<?php

namespace MVC;

class Router { //se encarga de tener todas las rutas, todos los controlladores y manda a llamar a ciertos metodos
    
    public $rutasGET = [];
    public $rutasPOST = []; //son arreglos porque la funcion que van a usar necesitan que sean arreglos


    public function get($url, $funt){ //recibe la url actual + la funcion asociada a esa url
        $this->rutasGET[$url] = $funt; //Señalo el array get en el indice url y le asigno la funcion
    }

    public function post($url, $funt){ 
        $this->rutasPOST[$url] = $funt; 
    }

    public function comprobarRutas(){
        session_start(); //tomo la info de la session actual
        $auth = $_SESSION['login'] ?? null; //si no existe asigna null


        //arreglo de rutas protegidas
        $rutas_protegidas = ['/admin' , '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        if (!$_SERVER['REQUEST_URI'] === '/') {
            $urlActual = rtrim($_SERVER['REQUEST_URI'],'/') ?? '/'; //si no existe el valor de path asignale una diagonal
        }else{
            $urlActual = $_SERVER['REQUEST_URI'] ?? '/';
        }
        
        $urlActual = explode("?",$urlActual)[0];
        $metodo = $_SERVER['REQUEST_METHOD']; //Tambien necesito el metodo que se solicita, tanto get como post
        
        if($metodo === 'GET'){ //si la ruta actual tiene el metodo get
        
            $funt = $this->rutasGET[$urlActual] ?? null; //tomo la funcion asociada a mi url actual de lo contrario le coloco null
        }else{
            $funt = $this->rutasPOST[$urlActual] ?? null; //lo mismo pero con post
        }

        //proteger las rutas
        if (in_array($urlActual, $rutas_protegidas) && !$auth) { //in_array permite revisar un elemento en el array $rutas_protegidas y retorna true o false
            header('Location: /');
        }

        if ($funt) { //si mi funcion existe
            call_user_func($funt, $this); //nos permite llamar a una funcion cuando no sabemos como se llama esa funcion
        }else{
            echo "pagina no encontrada";
        }


        
    }
    
    //MUESTRA UNA VISTA
    public function render($view, $datos = []){

        foreach($datos as $key=> $value){
            $$key = $value;
        }

        ob_start(); //inicia un almacenamiento en memoria
        include __DIR__ . "/views/$view.php"; //le asignamos vista dinamica que se almacena en la variable de contenido
        $contenido = ob_get_clean(); //despues limpia la memoria

        include __DIR__ . "/views/layout.php"; //luego incluimos la master page con el contenido inyectado, o sea la vista dinamica que le asignamos
    }
}