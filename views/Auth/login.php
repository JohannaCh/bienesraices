<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>

    <!-- por cada erro imprime en pantalla el mensaje -->
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error;?>
        </div>

    <?php endforeach; ?>

    <form method="POST" class="formulario" action="/login">
        <fieldset>
                <legend>Email y Password</legend>

                <label for="email">Email</label>
                <input name="email" type="email" placeholder="Ingrese su Email" id="email" >

                <label for="contraseña">Contraseña</label>
                <input name="password" type="password" placeholder="Ingresa tu Contraseña" id="contraseña" >
            </fieldset>

            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
    </form>
</main>
