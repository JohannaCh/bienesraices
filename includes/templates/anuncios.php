<?php 

    use App\Propiedad;


    if ($_SERVER['SCRIPT_NAME'] === '/anuncios.php') { //$_SERVER guarda datos del servidor - si estoy llamando desde anuncios.php 
        
        $propiedades = Propiedad::all(); //trae todas las propiedades que haya en la base de datos
    }else{ //de lo contrario
        $propiedades = Propiedad::getLimit(3); //trae las propiedades con el limite impuesto
    }

?>

    <div class="contenedor-anuncios">
            <?php foreach ($propiedades as $propiedad) {?>

                <div class="anuncio">  
                    <img src="/imagenes/<?php echo $propiedad->imagen;?>" alt="anuncio" loading="lazy">
                  
                    <div class="contenido-anuncio">
                        <h3 ><?php echo $propiedad->titulo;?></h3>
                        <p><?php echo $propiedad->descripcion;?></p>
                        <p class="precio"><?php echo $propiedad->precio;?></p>

                        <ul class="iconos-caracteristicas">
                            <li>
                                <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                                <p><?php echo $propiedad->wc;?></p>
                            </li>

                            <li>
                                <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                                <p><?php echo $propiedad->estacionamiento;?></p>
                            </li>
                            
                            <li>
                                <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                                <p><?php echo $propiedad->habitaciones;?></p>
                            </li>

                        </ul>
                        <a href="anuncio.php?id=<?php echo $propiedad->id;?>" class="boton-amarillo-block">ver propiedad</a>
                    </div>
                </div>
            <?php } ?>
        </div>
