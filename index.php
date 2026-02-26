<?php
// Configuración de la conexión a la base de datos
$servidor = "localhost:3307"; // Tu puerto específico
$usuario = "rosalinda";
$password = "Rosa123";
$base_datos = "practica_tablas";

$mensaje = "";

// Lógica para guardar cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
    $conn = new mysqli("localhost", $usuario, $password, $base_datos, 3307);

    $nombre = $_POST['nombre'];
    $tabla = $_POST['tabla'];
    $puntos = $_POST['puntos'];

    // 1. Guardar en MySQL
    $sql = "INSERT INTO resultados (nombre, tabla_practicada, puntuacion) VALUES ('$nombre', $tabla, $puntos)";
    $conn->query($sql);

    // 2. Guardar en archivo PHP (como historial de texto)
    $fecha = date("Y-m-d H:i:s");
    $linea = "<?php // Registro: $fecha | Usuario: $nombre | Tabla: $tabla | Puntos: $puntos / 10 ?>\n";
    file_put_contents("historial.php", $linea, FILE_APPEND);

    $mensaje = "¡Resultado guardado correctamente!";
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Practica Tablas Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="light-mode">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Desafío de Tablas (0-100)</h1>
            <button id="toggleTheme" class="btn btn-outline-secondary">🌙 Modo Noche</button>
        </div>

        <?php if($mensaje) echo "<div class='alert alert-success'>$mensaje</div>"; ?>

        <div class="card p-4 shadow">
            <div id="setup-section">
                <div class="mb-3">
                    <label>Tu Nombre:</label>
                    <input type="text" id="nombreUsuario" class="form-control" placeholder="Escribe tu nombre">
                </div>
                <div class="mb-3">
                    <label>¿Qué tabla quieres practicar? (0-100):</label>
                    <input type="number" id="tablaElegida" class="form-control" min="0" max="100">
                </div>
                <button onclick="comenzarPractica()" class="btn btn-primary w-100">Empezar</button>
            </div>

            <div id="quiz-section" style="display:none;">
                <h3 id="tituloQuiz"></h3>
                <div id="preguntasContainer"></div>
                <button onclick="calificar()" class="btn btn-success mt-3 w-100">Finalizar y Guardar</button>
            </div>
        </div>

        <form id="formOculto" method="POST" style="display:none;">
            <input type="hidden" name="nombre" id="postNombre">
            <input type="hidden" name="tabla" id="postTabla">
            <input type="hidden" name="puntos" id="postPuntos">
            <input type="hidden" name="guardar" value="1">
        </form>
    </div>

    <script src="java.js"></script>
</body>
</html>