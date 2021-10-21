document.addEventListener('DOMContentLoaded', function(){
    eventListeners();

    darkMode();
});

function eventListeners(){
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    //muestra campos condicionales

    //selecciono todos los inputs con el name contacto[contacto]
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input=> input.addEventListener('click', mostrarMetodosContacto));

    // console.log(metodoContacto);

}

function navegacionResponsive(){
    const navegacion = document.querySelector('.navegacion');

    if(navegacion.classList.contains('mostrar')){
        navegacion.classList.remove('mostrar');
    }else{
        navegacion.classList.add('mostrar');
    }
    // con "navegacion.classList.toggle('mostrar')" hago lo mismo pero mas limpio 

}

function darkMode(){
    const botonDarkMode = document.querySelector('.dark-mode-botton');
    botonDarkMode.addEventListener('click', function(){
        document.body.classList.toggle('dark-mode');
    });
}

function mostrarMetodosContacto(e){ //con e le pasamos un evento
    const contactoDiv = document.querySelector('#contacto') //la declaro y le asigno la seleccion

    if (e.target.value === 'telefono') { // Si el value del target que esta en mi event es igual a telefono
        contactoDiv.innerHTML = `
            <label for="telefono">Número de Teléfono</label>
            <input type="number" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]" >

            <p>Elija la fecha y la hora</p>

            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    }else{
        contactoDiv.innerHTML = `
            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu Email" id="email" name="contacto[mail]" >
        `;
    }
}