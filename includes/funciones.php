<?php

define('TEMPLATES_URL', __DIR__. '/templates');
define('FUNCIONES_URL', __DIR__. 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] .'/imagenes//');

function incluirTemplate($nombre, $inicio = false){
    include TEMPLATES_URL . "/${nombre}.php"; 
}

function estaAutenticado() {
    session_start();

    if(!$_SESSION['login']) {
        header('location: /');
    }
}

function debugear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}


//escapa el html
function sHtml($html): string {
    $sHtml = htmlspecialchars($html);
    return $sHtml;
}

//validar tipo de contenido

function validarTipoContenido($tipo){ 
    $tipos = ['vendedor', 'propiedad']; //si no se encuentra dentro de estos tipos no se ejecuta el codigo

    //va a buscar lo que esta en la variable $tipo en el array $tipos
    return in_array($tipo, $tipos); //in array permite buscar un string o un valor dentro de un arreglo - 
}

//muestra los mensajes

function mostrarNotificacion($codigo){ //toma el codigo del mensaje que necesitamos
    $mensaje = ''; //string vacio
    
     switch($codigo){  //evaluamos que condicion se cumple

        case 1:
            $mensaje = 'Creado Correctamente';
            break;

        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;

        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;

        default:
            $mensaje = false;
            break;
     }  

     return $mensaje; //devuelve el mensaje asignado a la variable
}

function validarORedireccionar(string $url){
        // validar el id
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
    
        //redireccionar en caso que sea invalido
        if (!$id) {
            header("location: ${url}");
        }
        return $id;
} 