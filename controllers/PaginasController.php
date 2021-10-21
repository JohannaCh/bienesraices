<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;


class PaginasController {

    public static function index(Router $router){
        
        $propiedades = Propiedad::getLimit(3); //uso el metodo para traer propiedaddes con un limite
        $inicio = true; //declaro la variable inicio para que aplique la clase que corresponde al banner de inicio

        //mostrar la vista
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router){
        
        
        $router->render('paginas/nosotros', []);
    }

    public static function propiedades(Router $router){

        $propiedades = Propiedad::all();
        
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router){

        $id = validarORedireccionar('/propiedades');

        //buscamos la propiedad por su id
        $propiedad = Propiedad::find($id);
        
        $router->render('paginas/propiedad',[
            'propiedad' => $propiedad 
        ]);
    }

    public static function blog(Router $router){
        
        $router->render('paginas/blog');
    }
    
    public static function entrada(Router $router){
        $router->render('paginas/entrada');
    }

    public static function contacto(Router $router){

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $respuestas = $_POST['contacto']; //coloco el array contacto enla variable rspuestas

            
            //crear una instancia de PHPMailer
            $mail = new PHPMailer();

            //configurar SMTP (protocolo que se utiliza para el envio de emails)
            $mail->isSMTP(); //le decimos que vamos a usar SMTP para enviar correos
            $mail->Host = 'smtp.mailtrap.io'; //cual es el dominio
            $mail->SMTPAuth = true; //signfica que nos vamos a autenticar
            $mail->Username = 'd23a1a80aa4a1b';
            $mail->Password = 'd4b147eb669baf';
            $mail->SMTPSecure = 'tls'; // es una manera de hacer que los mail viajen de forma segura sin que puedan interceptarlos
            $mail->Port = 2525; //el puerto sobre el cual se va a conectar

            // Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com'); //quien envia el email
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); //quien lo recibe
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8'; //se utiliza este porque se reciben mensajes con acentos etc.

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un Nuevo Mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre']. '</p>';  //inserto la informacion que corresponda a la variable contenido junto con el html

            //enviar de forma condicional algunos campos de email o telefono
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligió ser contactado vía Teléfono: </p>';
                $contenido .= '<p>Teléfono: ' . $respuestas['telefono']. '</p>';
                $contenido .= '<p>Fecha de Contacto: ' . $respuestas['fecha']. '</p>';
                $contenido .= '<p>Hora de Contacto: ' . $respuestas['hora']. '</p>';

            }else{ //es email, entonces
                $contenido .= '<p>Eligió ser contactado vía Email: </p>';
                $contenido .= '<p>Email: ' . $respuestas['mail']. '</p>';
            }

            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje']. '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo']. '</p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio']. '</p>';

            $contenido .= '</html>';

            $mail->Body = $contenido; //asignamos todo nuestro contenido para poder mostrarlo en el mensaje
            $mail->AltBody = 'este texto es alterno';

            //Enviar el email
            if ($mail->send()) { //retorna true o false en caso de enviarse o no
               $mensaje = "Mensaje Enviado Correctamente";
            }else{
                $mensaje = "El Mensaje no se pudo enviar";
            }
            


        }       
        $router->render('paginas/contacto', [
            'mensaje'=> $mensaje
        ]);
    }

}