function empezar() {
    const u = document.getElementById('user').value;
    const t = document.getElementById('num_tabla').value;
    if(!u || t==="") return alert("Faltan datos");

    document.getElementById('inicio').style.display = 'none';
    document.getElementById('quiz').style.display = 'block';
    document.getElementById('txtUser').innerText = `Estudiante: ${u} | Tabla del ${t}`;

    let h = "";
    for(let i=1; i<=10; i++) {
        h += `<div class="pregunta-fila"><span>${t} x ${i} = </span>
              <input type="number" class="form-control w-25 res" data-r="${t*i}"></div>`;
    }
    document.getElementById('preguntas').innerHTML = h;
}

function finalizar() {
    let pts = 0;
    let rev = "";
    const u = document.getElementById('user').value;
    const t = document.getElementById('num_tabla').value;

    document.querySelectorAll('.res').forEach((input, i) => {
        let respUser = parseInt(input.value) || 0;
        let respCorr = parseInt(input.dataset.r);
        let esCorrecto = respUser === respCorr;
        if(esCorrecto) pts++;

        rev += `<div class="list-group-item ${esCorrecto ? 'list-group-item-success' : 'list-group-item-danger'} d-flex justify-content-between">
                    <span>${t} x ${i+1} = ${respCorr}</span>
                    <span>${esCorrecto ? '✅' : '❌ Pusiste: '+respUser}</span>
                </div>`;
    });

    document.getElementById('resumenPuntos').innerText = `¡${u}, sacaste ${pts}/10!`;
    document.getElementById('listaRevision').innerHTML = rev;

    var modal = new bootstrap.Modal(document.getElementById('modalResultados'));
    modal.show();

    let d = new FormData();
    d.append('nombre', u); d.append('tabla', t); d.append('puntos', pts);
    fetch('index.php', { method: 'POST', body: d });
}

document.getElementById('btnTema').onclick = () => {
    document.body.classList.toggle('dark');
    document.getElementById('btnTema').innerText = document.body.classList.contains('dark') ? "☀️ Modo Día" : "🌙 Modo Noche";
};