<?php 

namespace Model;

class ActiveRecord{

    //base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];


    //definir la conexion a la bd
    public static function setDB($database){
        self::$db = $database; //no hace falta poner static porque se puede utilizar la misma conexion ya que viene de la clase padre
    }

    public function guardar(){
        if (!is_null($this->id)) { // si el valor de id no es null significa que existe y hay que actualizarlo
            $this->actualizar();
        }else{ //de lo contrario se debe crear
            $this->crear();
        }
    }

    public function crear(){

        //sanitizar los datos

        $atributos = $this->sanitizarAtributos();


        //insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . "( ";
        $query.= join(', ', array_keys($atributos));
        $query.= " ) VALUES (' ";
        $query.= join("', '", array_values($atributos));
        $query.= " ') ";

        // debugear($query);

        $resultado= self::$db->query($query);
        
        //mensaje de exito o error
        if($resultado){
            // Redireccionar al usuario

            header('location: /admin?resultado=1');
        }
    }

    public function actualizar(){
        //sanitizar los datos

        $atributos = $this->sanitizarAtributos();
        
        $valores = []; // va al objeto a memoria y une atributos con valores

        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";//este es el array que se va a ir llenandò
        }

        $query = " UPDATE " . static::$tabla . " SET ";
        $query.= join(',', $valores); //obtiene todos los valores del array en un string
        $query.= " WHERE id = '". self::$db->escape_string($this->id). "' "; //sanitizo los datos que mando a la base de datos
        $query.= " LIMIT 1";

        $resultado = self::$db->query($query); //mando mi consulta

        if($resultado){

            // Redireccionar al usuario
            header('location: /admin?resultado=2');
        }
    }

    //ELIMINAR UN REGISTRO
    public function eliminar(){
        $query = "DELETE FROM ". static::$tabla ." WHERE id = ". self::$db->escape_string($this->id)." LIMIT 1"; //convierto todo en string por seguridad
        $resultado = self::$db->query($query); //asigno a el resultado la conexion a la base de datos junto con la consulta

        if ($resultado) {
            $this->borrarImagen(); //llamo a la funcion
            header('location: /admin?resultado=3');
        }
    }

    //identificar y unir los atributos de la DB
    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            if($columna === 'id') continue; //ignora el id y lo quita del array porque hasta ahora no se conoce cual es el id
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){ 
        $atributos = $this->atributos();
        $sanitizado = [];

        // debugear('sanitizando...');

        foreach($atributos as $key => $value){ //key permite ver el nombre del atributo y value, el valor que se le asigna a ese atributo
            $sanitizado[$key] = self::$db->escape_string($value); //sanitiza volviendo string todo lo que hay en $value
        }
        return $sanitizado;
    }

    // subida de archivos
    public function setImage($imagen){ //pasamos una imagen

        //elimina la imagen previa

        if (!is_null($this->id)) { //compruebo si el id es null - el id se genera cuando instancio un objeto en memoria o sea crearlos
            $this->borrarImagen();
        }

        //asigna el nuevo
        if ($imagen) { //si existe
            $this->imagen = $imagen; //la asigna al objeto
        }
    }

    //eliminar el archivo
    public function borrarImagen(){
        //comprobar si existe el archivos
        $existeArchivo = file_exists(CARPETA_IMAGENES.$this->imagen); //le decimos donde buscarla y la referencia del nombre 

        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES.$this->imagen); //eliminamos archivo
        }
    }

    // validacion
    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){
        static::$errores = []; //permite limpiar el arreglo cada que validamos y obtener nuevos errores
        return static::$errores;
    }

    //lista todas las propiedades
    public static function all(){
        $query = "SELECT * FROM  ". static::$tabla ; //static permite heredad el metodo y buscar el atributo en la clase que se esta heredando

        $resultado = self::consultarSQL($query); //self siempre se refiere a la clase donde se esta utilizando

        return $resultado;
    }

    //obtiene determinado num de registros
    public static function getLimit($cantidad){
        $query = "SELECT * FROM  ". static::$tabla . " LIMIT " . $cantidad; //static permite heredad el metodo y buscar el atributo en la clase que se esta heredando

        $resultado = self::consultarSQL($query); //self siempre se refiere a la clase donde se esta utilizando

        return $resultado;
    }

    //busca un registro por su id
    public static function find($id){ //le paso el id
        $query = "SELECT * FROM ". static::$tabla ." WHERE id = ${id}"; //consulta buscando el id

        $resultado = self::consultarSQL($query);  //llama a consultar para instanciar otro objeto

        return array_shift($resultado);  //funcion que retorna el primer elemento de un array
    }

    public static function consultarSQL($query){
        //consultar la base de datos
        $resultado = self::$db->query($query);
        
        //iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){ //el while recorre mientras haya registros. el fetch toma los datos y crea una representacion de un array. 
            $array[] = static::crearObjeto($registro); //se llama a crear objeto pasandole los datos en registro para colocarlo dentro del array.
        }
    
        //liberar la memoria
        $resultado->free();
        
        //retornar los resultados
        return $array;
}



    protected static function crearObjeto($registro){
        //$objeto = new self; permite crear un objeto dentro de la misma clase, se utiliza self para referirse a la misma clase

        $objeto = new static; //hace referencia a la clase que lo esta utilizando
        foreach($registro as $key => $value){
            if ( property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = [] ){
        foreach($args as $key => $value ){ //para cada arg del array toma el $key y $value

            if (property_exists($this, $key) && !is_null($value)) { //revisa si existe $key y si $value no es null
                $this->$key = $value; //le asigna el $value a la $key del objeto / al tener la variable $key es mas dinamico con los atributos
            }

        }
    }
}

