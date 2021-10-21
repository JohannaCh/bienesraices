<main class="contenedor seccion">
    <h1>Contacto</h1>

    <?php 
    if ($mensaje) {
        echo "<p class='alerta exito'>".$mensaje."</p>";
    }?>

    <picture> 
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="imagen fondo de contacto">
    </picture>

    <h2>Llene el Formulario de Contacto</h2>
    <form class="formulario" action="/contacto" method="POST">
        <fieldset>
            <legend>Información Personal</legend>

            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]"  required>   <!--  Coloco name="contacto[nombre]" para agruparlo en un array -->
            <label for="mensaje">Mensaje</label>
            <textarea type="text" placeholder="Tu Mensaje" id="mensaje" name="contacto[mensaje]" required></textarea>
        </fieldset>

        <fieldset>
            <legend>Información sobre la propiedad</legend>

            <label for="opciones">Vende o Compra</label>
            <select id="opciones" name="contacto[tipo]" >
                <option value="" disabled selected>--Selecciones una opción--</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Precio o Presupuesto" id="presupuesto" name="contacto[precio]" required >

        </fieldset>

        <fieldset>
            <legend>Contacto</legend>

            <p>Como Desea ser Contactado</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input type="radio" value="telefono" id="contactar-telefono" name="contacto[contacto]" required >

                <label for="contactar-email">E-mail</label>
                <input type="radio" value="email" id="contactar-email" name="contacto[contacto]"  required>
            </div>

            <div id="contacto"></div>

        </fieldset>

        <input type="submit" value="enviar" class="boton-verde">

    </form>

</main>