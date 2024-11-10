<?php
// Parámetros de conexión
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mariscos';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$tabla = $_GET['tabla'];
$id = $_GET['id'];

// Obtener los datos del registro
$sql = "SELECT * FROM $tabla WHERE id = $id";
$result = $conn->query($sql);
$registro = $result->fetch_assoc();

// Actualizar el registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updates = [];
    foreach ($_POST as $key => $value) {
        $updates[] = "$key = '$value'";
    }
    $update_sql = "UPDATE $tabla SET " . implode(", ", $updates) . " WHERE id = $id";
    if ($conn->query($update_sql) === TRUE) {
        echo "Registro actualizado correctamente";
        header("Location: sistema.php"); // Redirigir después de actualizar
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
</head>
<body
