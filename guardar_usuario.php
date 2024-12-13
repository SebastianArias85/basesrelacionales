<?php
// Incluir el archivo de conexión
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $iosfa = $_POST['iosfa'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $descripcion = $_POST['descripcion'];
    $amo = $_POST['amo'];
    $tipo_animal = $_POST['tipo_animal'];  // Tipo de animal (domestico o granja)

    // Insertar la mascota
    $stmt_mascota = $pdo->prepare("INSERT INTO mascotas (iosfa, nombre, edad, descripcion, tipo_animal) VALUES (?, ?, ?, ?, ?)");
    $stmt_mascota->execute([$iosfa, $nombre, $edad, $descripcion, $tipo_animal]);

    // Insertar el amo (la relación con la mascota usando el mismo iosfa)
    $stmt_amo = $pdo->prepare("INSERT INTO amos (iosfa, amo) VALUES (?, ?)");
    $stmt_amo->execute([$iosfa, $amo]);

    // Redirigir a la página principal
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Nueva Mascota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Cargar Nueva Mascota</h2>
        <form action="guardar_usuario.php" method="POST">
            <br>
            <h4>TIPO DE ANIMAL</h4>
            <div class="mb-3">
                <label for="tipo_animal" class="form-label">Tipo de Animal</label>
                <select class="form-control" id="tipo_animal" name="tipo_animal" required>
                    <option value="domestico">Doméstico</option>
                    <option value="granja">Granja</option>
                </select>
            </div>

            <h4>DATOS BASICOS</h4>
            <div class="mb-3">
                <label for="iosfa" class="form-label">IOSFA</label>
                <input type="number" class="form-control" id="iosfa" name="iosfa" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Mascota</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" class="form-control" id="edad" name="edad" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>

            <h4>DATOS DE DUEÑO</h4>
            <div class="mb-3">
                <label for="amo" class="form-label">Nombre del Amo</label>
                <input type="text" class="form-control" id="amo" name="amo" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
