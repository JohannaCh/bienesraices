<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo sHtml($propiedad->titulo); ?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo sHtml($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

    <?php if ($propiedad->imagen): //si hay algo ahi ?>
       <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small" alt="">  <!-- Si existe que muestre la imagen -->
    <?php endif;?>


    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="propiedad[descripcion]" ><?php echo sHtml($propiedad->descripcion); ?></textarea>
    

</fieldset>

<fieldset>
    <legend>Información de la Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?php echo sHtml($propiedad->habitaciones); ?>">

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" min="1" max="9" value="<?php echo sHtml($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 3" min="1" max="9" value="<?php echo sHtml($propiedad->estacionamiento); ?>">

</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedorId]" id="vendedor">
        <!-- iteramos entre los resultados -->
        <option selected value=""> -- Seleccione un vendedor --</option>
        <?php foreach($vendedores as $vendedor){ ?> 
            <!-- guardo el id que seleccione luego comparo si alguno de mis option coinciden con el guardado y le pongo la opcion selected, de lo contrario lo dejo en null -->
            <option 
                <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected': '';?> 
                value="<?php echo sHtml($vendedor->id); ?>"> 
            <?php echo sHtml($vendedor->nombre) . " " . sHtml($vendedor->apellido); ?> </option>  <!-- sanitizo el html antes de pasarlo -->
        <?php } ?>
    </select>
</fieldset>