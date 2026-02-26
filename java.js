function empezar() {
    const user = document.getElementById('user').value;
    const tabla = document.getElementById('num_tabla').value;
    
    if(!user || tabla === "") {
        alert("Por favor, ingresa tu nombre y la tabla.");
        return;
    }

    document.getElementById('inicio').style.display = 'none';
    document.getElementById('quiz').style.display = 'block';
    document.getElementById('txtUser').innerText = "Estudiante: " + user;

    let container = document.getElementById('preguntas');
    container.innerHTML = "";

    for(let i=1; i<=10; i++) {
        container.innerHTML += `
            <div class="pregunta-fila">
                <span>${tabla} x ${i} = </span>
                <input type="number" class="form-control w-25 res-input" data-r="${tabla * i}">
            </div>`;
    }
}

function finalizar() {
    let puntos = 0;
    let revision = "";
    const user = document.getElementById('user').value;
    const tabla = document.getElementById('num_tabla').value;
    const inputs = document.querySelectorAll('.res-input');

    inputs.forEach((input, i) => {
        let respUser = parseInt(input.value) || 0;
        let respCorr = parseInt(input.dataset.r);
        let esCorrecto = (respUser === respCorr);
        
        if(esCorrecto) puntos++;

        revision += `
            <div class="list-group-item ${esCorrecto ? 'list-group-item-success' : 'list-group-item-danger'} d-flex justify-content-between">
                <span>${tabla} x ${i+1} = ${respCorr}</span>
                <span>${esCorrecto ? '✅' : '❌ Pusiste: '+respUser}</span>
            </div>`;
    });

    // Mostrar resultados en el Modal
    document.getElementById('resumenPuntos').innerText = "¡" + user + ", lograste " + puntos + "/10!";
    document.getElementById('listaRevision').innerHTML = revision;

    let modalResultados = new bootstrap.Modal(document.getElementById('modalResultados'));
    modalResultados.show();

    // Guardar en la Base de Datos
    let datos = new FormData();
    datos.append('nombre', user);
    datos.append('tabla', tabla);
    datos.append('puntos', puntos);
    
    fetch('index.php', { method: 'POST', body: datos });
}

// Botón de Modo Noche
document.getElementById('btnTema').onclick = function() {
    document.body.classList.toggle('dark');
    this.innerText = document.body.classList.contains('dark') ? "☀️ Modo Día" : "🌙 Modo Noche";
};