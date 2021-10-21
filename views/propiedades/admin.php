<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>

    <?php
    
        if ($resultado) {
            //intval lo convierte en un entero
            $mensaje = mostrarNotificacion( intval($resultado)); //compara el codigo con los valores de resultado que le asignamos a 'crear', 'actualiza' y 'eliminar'
            
            //evaluamos si hay un mensaje de lo contrario no mostramos nada
            if ($mensaje) { ?>
                <p class = "alerta exito"><?php echo sHtml($mensaje) ?></p>
            <?php }
        } 
    ?>
        
    <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/vendedores/crear" class="boton boton-amarillo">Nuevo Vendedor</a>
    
    <h2>Propiedades</h2>

    <table class="propiedades">
        <thead>
            <th>ID</th>
            <th>Titulo</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Acciones</th>
        </thead>

        <tbody>

            <?php foreach( $propiedades as $propiedad): ?>
            <tr>
                <td><?php echo $propiedad->id;?> </td>
                <td><?php echo $propiedad->titulo;?></td>
                <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="" class="imagen-tabla"></td>
                <td><?php echo $propiedad->precio;?></td>
                <td>
                    <form action="/propiedades/eliminar" method="POST" class="w-100">
                        <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                        <input type="hidden" name="tipo" value="propiedad">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                    </form>
                    <a href="/propiedades/actualizar?id=<?php echo $propiedad->id;?>" class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

    <h2>Vendedores</h2>

        <table class="propiedades">
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </thead>

            <tbody>

                <?php foreach( $vendedores as $vendedor): ?> <!-- por cada vendedor un "objeto->vendedor" -->
                <tr>
                    <td><?php echo $vendedor->id;?> </td>
                    <td><?php echo $vendedor->nombre . " ". $vendedor->apellido;?></td>
                    <td><?php echo $vendedor->telefono;?></td>
                    <td>
                        <form action="/vendedores/eliminar" method="POST" class="w-100">

                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">

                        </form>

                        <a href="vendedores/actualizar?id=<?php echo $vendedor->id;?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
</main>
    