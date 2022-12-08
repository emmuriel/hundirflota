/*Script para la política de cookies */

const btnAceptar = document.getElementById('aceptarCookies');
const avisoCookies = document.getElementById('banner-cookies');
const fondoAvisoCookies = document.getElementById('fondo-aviso-cookies');

if (!localStorage.getItem('hundirlaflota-acceptedCookies')){
avisoCookies.classList.add('activo');
fondoAvisoCookies.classList.add('activo');
}

btnAceptar.addEventListener('click', () => {
    avisoCookies.classList.remove('activo');
    fondoAvisoCookies.classList.remove('activo');

    //Almacenar aceptacion
    localStorage.setItem('hundirlaflota-acceptedCookies', true);
});

