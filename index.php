<?php
$conn = new mysqli("127.0.0.1", "rosalinda", "Rosa123", "practica_tablas", 3307);
if ($conn->connect_error) { $error_msg = "Error: " . $conn->connect_error; }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $tabla = intval($_POST['tabla']);
    $puntos = intval($_POST['puntos']);
    $stmt = $conn->prepare("INSERT INTO resultados (nombre, tabla_practicada, puntuacion) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $nombre, $tabla, $puntos);
    if($stmt->execute()){
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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Desafío de Tablas</h4>
                        <button id="btnTema" class="btn btn-sm btn-outline-light">🌙 Modo Noche</button>
                    </div>
                    <div class="card-body p-4">
                        <div id="inicio">
                            <input type="text" id="user" class="form-control mb-3" placeholder="Tu nombre">
                            <input type="number" id="num_tabla" class="form-control mb-3" placeholder="Tabla (0-100)">
                            <button onclick="empezar()" class="btn btn-primary w-100 btn-lg">¡Empezar Desafío!</button>
                        </div>
                        <div id="quiz" style="display:none;">
                            <h5 id="txtUser" class="mb-4 fw-bold"></h5>
                            <div id="preguntas"></div>
                            <button onclick="finalizar()" class="btn btn-success w-100 mt-4 shadow">Finalizar y Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalResultados" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content card">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tu Resultado</h5>
                </div>
                <div class="modal-body">
                    <h4 id="resumenPuntos" class="text-center mb-3"></h4>
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