function comenzarPractica() {
    const nombre = document.getElementById('nombreUsuario').value;
    const tabla = document.getElementById('tablaElegida').value;

    if (!nombre || tabla === "") {
        alert("Por favor llena todos los campos");
        return;
    }

    document.getElementById('setup-section').style.display = 'none';
    document.getElementById('quiz-section').style.display = 'block';
    document.getElementById('tituloQuiz').innerText = `Tabla del ${tabla} - Practicando: ${nombre}`;

    let container = document.getElementById('preguntasContainer');
    container.innerHTML = "";

    for (let i = 1; i <= 10; i++) {
        container.innerHTML += `
            <div class="pregunta-row">
                ${tabla} x ${i} = 
                <input type="number" class="respuesta-user form-control d-inline-block w-25" data-correcta="${tabla * i}">
            </div>`;
    }
}

function calificar() {
    let inputs = document.querySelectorAll('.respuesta-user');
    let aciertos = 0;

    inputs.forEach(input => {
        if (parseInt(input.value) === parseInt(input.dataset.correcta)) {
            aciertos++;
        }
    });

    // Llenar formulario oculto para PHP
    document.getElementById('postNombre').value = document.getElementById('nombreUsuario').value;
    document.getElementById('postTabla').value = document.getElementById('tablaElegida').value;
    document.getElementById('postPuntos').value = aciertos;

    // Enviar a la base de datos
    document.getElementById('formOculto').submit();
}

// Botón Modo Noche/Día
document.getElementById('toggleTheme').addEventListener('click', () => {
    const body = document.body;
    if (body.classList.contains('light-mode')) {
        body.classList.replace('light-mode', 'dark-mode');
        document.getElementById('toggleTheme').innerText = "☀️ Modo Día";
    } else {
        body.classList.replace('dark-mode', 'light-mode');
        document.getElementById('toggleTheme').innerText = "🌙 Modo Noche";
    }
});