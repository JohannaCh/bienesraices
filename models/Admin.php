<?php

namespace Model; //una etiqueta que me permite agrupar distintas clases

class Admin extends ActiveRecord{

    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    //atributos de la clase por lo tanto son public para acceder a ellos tanto este modelo como en este controlador
    public $id;
    public $email;
    public $password;

    public function __construct($args = []) //constructor de esta clase 
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->password = $args['password'] ?? null;
    }

    public function validar(){ //validar que depende de cada clase
        if (!$this->email) { //si el email esta vacio, o sea no existe el dato email
            self::$errores[] = 'El email es obligatorio'; //self hace referencia a la clase que lo utiliza unicamente 
        }
        if (!$this->password) { 
            self::$errores[] = 'La contraseña obligatoria'; //self hace referencia a la clase que lo utiliza unicamente 
        }
        return self::$errores; // devolvemos el resultado de la validacion con alertas de errores en caso que sea necesario

        }

    public function existeUsuario(){
        //revisar si el usuario existe o no
        $query = "SELECT * FROM ". self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if (!$resultado->num_rows) { //num bows es mi indicativo para saber si hay resultados o no
            self::$errores[] = 'El usuario no existe';
            return; //para que el codigo deje de ejecutarse
        }
        return $resultado; //en caso de no existir un error retorna el resultado


    }  

    public function comprobarPassword($resultado){
        $usuario = $resultado->fetch_object(); //trae el resultado de lo que encuentra en la base de datos y lo coloca en usuario

        //lo colocamos en una variable porque retorna true o false
       $autenticado = password_verify($this->password, $usuario->password); //toma 2 parametros el pass que vamos a comparar y el pass de la base 

       if (!$autenticado) {
            self::$errores[] = 'El usuario no existe';
       }
       return $autenticado; // retorna si esta autenticado o no

    }

    public function autenticar(){
        session_start(); //asi se inicia accediendo a la sesion actual

        //llenar el arreglo de session
        $_SESSION['usuario'] = $this->email;//$_SESSION['USUARIO'] es para tener la referencia de quien inicio sesion
        $_SESSION['login'] = true;

        header('location: /admin'); // redireccionamos a admin 

    }
}