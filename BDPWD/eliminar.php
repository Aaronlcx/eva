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

// Eliminar el registro
$sql = "DELETE FROM $tabla WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "Registro eliminado correctamente";
    header("Location: sistema.php"); // Redirigir después de eliminar
} else {
    echo "Error al eliminar: " . $conn->error;
}

$conn->close();
?>
