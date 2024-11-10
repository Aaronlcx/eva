<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mariscos';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


function mostrar_tabla($consulta, $conn, $tabla) {
    $resultado = $conn->query($consulta);
    
    if ($resultado->num_rows > 0) {
        echo "<table border='1' style='width: 100%; margin-bottom: 20px;'>";
        echo "<thead><tr>";


        $fields = $resultado->fetch_fields();
        foreach ($fields as $field) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "<th>Acciones</th></tr></thead><tbody>";


        while ($row = $resultado->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
   
            $id = isset($row['id']) ? $row['id'] : 'id_no_definido';
            echo "<td>
                    <a href='editar.php?tabla=$tabla&id=$id'>Editar</a> | 
                    <a href='eliminar.php?tabla=$tabla&id=$id' onclick='return confirm(\"¿Estás seguro que deseas eliminar este registro?\")'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "No hay resultados";
    }
}


$consulta_proveedores = "SELECT * FROM proveedores";
$consulta_facturas = "SELECT * FROM facturas";
$consulta_articulos = "SELECT * FROM articulos";
$consulta_clientes = "SELECT * FROM clientes";


$busqueda = '';
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['buscar'];
    

    $consulta_proveedores = "SELECT * FROM proveedores WHERE nombre LIKE '%$busqueda%' OR email LIKE '%$busqueda%' OR producto LIKE '%$busqueda%'";
    $consulta_facturas = "SELECT * FROM facturas WHERE fecha_factura LIKE '%$busqueda%' OR monto_total LIKE '%$busqueda%'";
    $consulta_articulos = "SELECT * FROM articulos WHERE nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%'";
    $consulta_clientes = "SELECT * FROM clientes WHERE nombre LIKE '%$busqueda%' OR email LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%'";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="sistema.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión - Restaurante Mariscos del Mar</title>
</head>
<body>

    <header>
        <nav>
            <ul>
            <li><a href="mariscos.html">Bienvenida</a></li>
                <li><a href="menu.html">Menú</a></li>
                <li><a href="sistema.php">Sistema</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Sistema de Gestión</h1>
        <p>Consulta de las tablas de la base de datos.</p>


        <form method="POST" action="sistema.php">
            <label for="buscar">Buscar:</label>
            <input type="text" id="buscar" name="buscar" value="<?php echo $busqueda; ?>" placeholder="Ingresa palabra clave">
            <input type="submit" value="Buscar">
        </form>

        <h2>Proveedores</h2>
        <?php mostrar_tabla($consulta_proveedores, $conn, 'proveedores'); ?>
        <a href="agregar.php?tabla=proveedores">Agregar Proveedor</a>

        <h2>Facturas</h2>
        <?php mostrar_tabla($consulta_facturas, $conn, 'facturas'); ?>
        <a href="agregar.php?tabla=facturas">Agregar Factura</a>

        <h2>Artículos</h2>
        <?php mostrar_tabla($consulta_articulos, $conn, 'articulos'); ?>
        <a href="agregar.php?tabla=articulos">Agregar Artículo</a>

        <h2>Clientes</h2>
        <?php mostrar_tabla($consulta_clientes, $conn, 'clientes'); ?>
        <a href="agregar.php?tabla=clientes">Agregar Cliente</a>

    </main>

    <footer>
        <p>&copy; 2163917.</p>
    </footer>

</body>
</html>

<?php

$conn->close();
?>
