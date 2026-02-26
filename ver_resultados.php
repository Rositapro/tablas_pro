<?php
// Configuración de conexión con tus datos específicos
$host = "127.0.0.1";
$user = "rosalinda";
$pass = "Rosa123";
$db   = "practica_tablas";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar todos los resultados, el más reciente primero
$sql = "SELECT id, nombre, tabla_practicada, puntuacion, fecha_hora FROM resultados ORDER BY id DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Resultados - Kitty Beauty Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .table-container { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>📊 Historial de Prácticas</h2>
            <a href="index.php" class="btn btn-outline-primary">⬅ Volver a Practicar</a>
        </div>

        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Estudiante</th>
                        <th>Tabla</th>
                        <th>Puntuación</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = $res->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#<?php echo $fila['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                        <td>Tabla del <?php echo $fila['tabla_practicada']; ?></td>
                        <td>
                            <span class="badge <?php echo $fila['puntuacion'] >= 7 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo $fila['puntuacion']; ?> / 10
                            </span>
                        </td>
                        <td><?php echo $fila['fecha_hora']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php if ($res->num_rows == 0): ?>
                <p class="text-center text-muted mt-3">Aún no hay resultados registrados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>