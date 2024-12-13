<?php
// Incluir el archivo de conexión
include('db.php');

$iosfa = isset($_GET['iosfa']) ? $_GET['iosfa'] : 0;
$query_mascota = $pdo->prepare("SELECT * FROM Mascotas WHERE iosfa = ?");
$query_mascota->execute([$iosfa]);
$mascota = $query_mascota->fetch(PDO::FETCH_ASSOC);

$query_amos = $pdo->prepare("SELECT * FROM Amos WHERE iosfa = ?");
$query_amos->execute([$iosfa]);
$amos = $query_amos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Mascota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Detalles de <?php echo $mascota['nombre']; ?></h2>
    
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" id="mascotas-tab" data-bs-toggle="tab" href="#mascotas">Mascotas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="amos-tab" data-bs-toggle="tab" href="#amos">Amos</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="mascotas">
            <h4>Información de la Mascota</h4>
            <p><strong>Nombre:</strong> <?php echo $mascota['nombre']; ?></p>
            <p><strong>Edad:</strong> <?php echo $mascota['edad']; ?> años</p>
            <p><strong>Descripción:</strong> <?php echo $mascota['descripcion']; ?></p>
        </div>
        <div class="tab-pane fade" id="amos">
            <h4>Amos Relacionados</h4>
            <?php if (count($amos) > 0): ?>
                <ul>
                    <?php foreach ($amos as $amo): ?>
                        <li><strong>Amo:</strong> <?php echo $amo['amo']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay amos registrados para esta mascota.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
