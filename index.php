<?php
// Conexión a la base de datos
$conn = new mysqli("127.0.0.1", "rosalinda", "Rosa123", "practica_tablas", 3307);

// Procesar el guardado de datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $tabla = intval($_POST['tabla']);
    $puntos = intval($_POST['puntos']);
    
    // Guardar en MySQL
    $stmt = $conn->prepare("INSERT INTO resultados (nombre, tabla_practicada, puntuacion) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $nombre, $tabla, $puntos);
    
    if($stmt->execute()){
        // Guardar en el archivo historial.php
        $registro = "<?php // " . date('Y-m-d H:i:s') . " | $nombre | Score: $puntos/10 ?>\n";
        file_put_contents("historial.php", $registro, FILE_APPEND);
        echo "success";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas Pro | Rosalinda</title>
    <link rel="icon" type="image/png" href="icono.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="card shadow-lg border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Desafío de Tablas</h4>
            <button id="btnTema" class="btn btn-sm btn-outline-light">🌙 Modo Noche</button>
        </div>
        <div class="card-body p-4">
            <div id="inicio">
                <div class="text-center mb-4">
                    <img src="icono.png" width="60" alt="logo" class="mb-2">
                    <h5 class="fw-bold" style="color: #590d22">¡Bienvenida, Rosalinda!</h5>
                </div>
                <label class="fw-bold">Tu Nombre:</label>
                <input type="text" id="user" class="form-control mb-3" placeholder="Escribe tu nombre">
                
                <label class="fw-bold">Tabla a practicar:</label>
                <input type="number" id="num_tabla" class="form-control mb-4" placeholder="0 - 100">
                
                <button type="button" onclick="empezar()" class="btn btn-primary w-100 btn-lg shadow">¡Empezar!</button>
            </div>
            
            <div id="quiz" style="display:none;">
                <h5 id="txtUser" class="mb-4 fw-bold text-center"></h5>
                <div id="preguntas"></div>
                <button type="button" onclick="finalizar()" class="btn btn-success w-100 mt-4 shadow">Finalizar y Guardar</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalResultados" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content card" style="background: white !important;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tu Resultado</h5>
                </div>
                <div class="modal-body">
                    <h4 id="resumenPuntos" class="text-center mb-3" style="color: #212529 !important;"></h4>
                    <div id="listaRevision" class="list-group"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="location.reload()">Cerrar y Volver</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="java.js"></script>
</body>
</html>