document.addEventListener('DOMContentLoaded', function(){

    eventListeners();
    darkMode();
});

function darkMode(){

    const prefierDarkMOde = window.matchMedia('(prefers-color-scheme: dark)');
    //console.log(prefierDarkMOde.matches);

    if (prefierDarkMOde.matches) {
        document.body.classList.add('dark-mode')
    } else {
        document.body.classList.remove('dark-mode')
    }

    prefierDarkMOde.addEventListener('change', function(){
        if (prefierDarkMOde.matches) {
            document.body.classList.add('dark-mode')
        } else {
            document.body.classList.remove('dark-mode')
        }
    });


    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function(){
        document.body.classList.toggle('dark-mode');

         //Para que el modo elegido se quede guardado en local-storage
         if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('modo-oscuro','true');
        } else {
            localStorage.setItem('modo-oscuro','false');
        }
    });
 
    //Obtenemos el modo del color actual
    if (localStorage.getItem('modo-oscuro') === 'true') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
    
}

function eventListeners(){
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    //Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
}

function mostrarMetodosContacto(e)
{
    const contactoDiv = document.querySelector('#contacto');

    if(e.target.value === 'telefono')
    {
        contactoDiv.innerHTML = ` 
        <label for="telefono">Número Teléfono</label>
        <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">

        <p>Elija la Fecha y la Hora para la Llamada</p>
        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="contacto[fecha]">

        <label for="hora">Hora</label>
        <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">

        `;
    }else
    {
        contactoDiv.innerHTML = ` 
        
        <label for="email">E-mail</label>
        <input type="email" placeholder="Tu E-mail" id="email" name="contacto[email]" >

        `;
    }
    
}


