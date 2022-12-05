let ciclo = document.querySelector("#ciclo");
let secundaria = document.querySelectorAll('.Secundaria');
let primaria = document.querySelectorAll('.Primaria');

console.log(ciclo.value);
console.log(secundaria);


mostrarCiclo();
ciclo.onchange = function () { mostrarCiclo() }

function mostrarCiclo() {
    if (ciclo.value == 2) {
        secundaria.forEach(el => {
            el.style.display = 'inline';
        })
        primaria.forEach(el => {
            el.style.display = 'none';
        })

    } else if (ciclo.value == 1) {
            secundaria.forEach(el => {
                el.style.display = 'none';
            })
            primaria.forEach(el => {
                el.style.display = 'inline';
            })

    } else if (ciclo.value == -1) {
            secundaria.forEach(el => {
                el.style.display = 'none';
            })
            primaria.forEach(el => {
                el.style.display = 'none';
            })

    }
}





