let ciclo = document.querySelector("#ciclo");
let secundaria = document.querySelector('#secundaria');
let primaria = document.querySelector('#primaria');
let labelGrado = document.querySelector('#labelGrado');

mostrarCiclo();
ciclo.onchange = function () { mostrarCiclo() }

function mostrarCiclo() {
    if (ciclo.value == "Secundaria") {
        secundaria.style.display = 'inline';
        labelGrado.style.display = 'inline';
        primaria.style.display = 'none';

    } else if (ciclo.value == "Primaria") {
        labelGrado.style.display = 'inline';
        secundaria.style.display = 'none';
        primaria.style.display = 'inline';

    } else if (ciclo.value == "Todos") {
        primaria.style.display = 'none';
        secundaria.style.display = 'none';
        labelGrado.style.display = 'none';

    }
}

let botones = document.querySelectorAll('.boton-lista');
console.log(botones);





