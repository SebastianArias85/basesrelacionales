<?php
// Incluir el archivo de conexión
include('db.php');

// Establecer el tipo de animal a filtrar (por defecto mostrar todos)
$tipo_filtro = '';

// Verificar qué filtro se selecciona
if (isset($_GET['filtro'])) {
    if ($_GET['filtro'] == 'domestico') {
        $tipo_filtro = 'domestico';
    } elseif ($_GET['filtro'] == 'granja') {
        $tipo_filtro = 'granja';
    }
}

// Construir la consulta con el filtro correspondiente
if ($tipo_filtro) {
    $query_mascotas = "SELECT * FROM Mascotas WHERE tipo_animal = ?";
    $stmt_mascotas = $pdo->prepare($query_mascotas);
    $stmt_mascotas->execute([$tipo_filtro]);
} else {
    // Si no hay filtro, mostrar todas las mascotas
    $query_mascotas = "SELECT * FROM Mascotas";
    $stmt_mascotas = $pdo->query($query_mascotas);
}

$mascotas = $stmt_mascotas->fetchAll(PDO::FETCH_ASSOC);

// Obtener la cantidad de mascotas por tipo para el gráfico
$query = "SELECT tipo_animal, COUNT(*) as cantidad FROM Mascotas GROUP BY tipo_animal";
$stmt = $pdo->query($query);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inicializar las variables para el gráfico
$domesticos = 0;
$granja = 0;

foreach ($tipos as $tipo) {
    if ($tipo['tipo_animal'] == 'domestico') {
        $domesticos = $tipo['cantidad'];
    } elseif ($tipo['tipo_animal'] == 'granja') {
        $granja = $tipo['cantidad'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Mascotas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">    
</head>
<body>
<div class="container mt-5">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <a class="navbar-brand" href="#">Mascotas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?filtro=domestico">Ver Solo Domésticos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?filtro=granja">Ver Solo de Granja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Ver Todos</a>
                </li>
            </ul>
        </div>
    </nav>

    <h2>Lista de Mascotas</h2>
    <a href="guardar_usuario.php" class="btn btn-primary mb-3">Cargar Nueva Mascota</a>

    <!-- Tabla de Mascotas -->
    <table class="table">
        <thead>
            <tr>
                <th>IOSFA</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mascotas as $mascota): ?>
            <tr>
                <td><?php echo $mascota['iosfa']; ?></td>
                <td><?php echo $mascota['nombre']; ?></td>
                <td><?php echo $mascota['edad']; ?></td>
                <td><?php echo $mascota['descripcion']; ?></td>
                <td><?php echo ucfirst($mascota['tipo_animal']); ?></td>
                <td>
                    <a href="ver_usuario.php?iosfa=<?php echo $mascota['iosfa']; ?>" class="btn btn-info">Ver</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Gráfico de torta más pequeño -->
    <h3>Distribución de Mascotas</h3>
    <canvas id="graficoTorta"></canvas>
    <script>
        var ctx = document.getElementById('graficoTorta').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Animales Domésticos', 'Animales de Granja'],
                datasets: [{
                    label: 'Cantidad de Animales',
                    data: [<?php echo $domesticos; ?>, <?php echo $granja; ?>],
                    backgroundColor: ['#36a2eb', '#ff6384'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
