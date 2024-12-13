<?php
// Datos de conexión a la base de datos
$host = 'localhost'; 
$dbname = 'animal';  
$username = 'root';  
$password = '';       

try {
    // Crear una instancia de PDO para la conexión
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error de conexión, se muestra el mensaje
    echo 'Error de conexión: ' . $e->getMessage();
    exit();
}
?>
