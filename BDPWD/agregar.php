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

// Recibir el tipo de tabla
$tabla = $_GET['tabla'];

// Insertar datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $campos = [];
    $valores = [];
    foreach ($_POST as $key => $value) {
        $campos[] = $key;
        $valores[] = "'$value'";
    }
    $sql = "INSERT INTO $tabla (" . implode(", ", $campos) . ") VALUES (" . implode(", ", $valores) . ")";
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo registro agregado correctamente";
        header("Location: sistema.php"); // Redirigir después de agregar
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Registro</title>
</head>
<body>

    <header>
        <nav>
            <ul>
                <li><a href="sistema.php">Sistema</a></li>
            </ul>
        </nav>
    </header>

    <h1>Agregar Registro en la Tabla <?php echo ucfirst($tabla); ?></h1>

    <form method="POST" action="">
        <?php
        // Mostrar campos de la tabla de forma automática
        $result = $conn->query("SHOW COLUMNS FROM $tabla");
        while ($row = $result->fetch_assoc()) {
            $campo = $row['Field'];
            if ($campo != 'id') { // Excluir el campo id que es autoincremental
                echo "<label for='$campo'>$campo</label><br>";
                echo "<input type='text' name='$campo' id='$campo' required><br><br>";
            }
        }
        ?>
        <input type="submit" value="Agregar">
    </form>

</body>
</html>

<?php
$conn->close();
?>
