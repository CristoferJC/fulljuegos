<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = mysqli_real_escape_string($conex, $_POST['nombre']);
    $precio = mysqli_real_escape_string($conex, $_POST['precio']);
    
    $query = "UPDATE venta_juegos SET Nombre='$nombre', Precio='$precio'";
    
    // Manejo de la nueva imagen si se ha subido una
    if (isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0) {
        $imagen = $_FILES['imagen'];
        $nombre_imagen = time() . '_' . $imagen['name'];
        $ruta_destino = "assets/images/juegos/" . $nombre_imagen;
        
        // Obtener y eliminar la imagen anterior
        $query_imagen_anterior = "SELECT Imagen FROM venta_juegos WHERE ID=$id";
        $result = mysqli_query($conex, $query_imagen_anterior);
        $row = mysqli_fetch_assoc($result);
        if ($row['Imagen']) {
            $ruta_imagen_anterior = "assets/images/juegos/" . $row['Imagen'];
            if (file_exists($ruta_imagen_anterior)) {
                unlink($ruta_imagen_anterior);
            }
        }
        
        if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
            $query .= ", Imagen='$nombre_imagen'";
        }
    }
    
    $query .= " WHERE ID=$id";
    
    if (mysqli_query($conex, $query)) {
        header("Location: controlpanel.php");
    } else {
        echo "Error: " . mysqli_error($conex);
    }
} else {
    $id = $_GET['id'];
    $query = "SELECT * FROM venta_juegos WHERE ID=$id";
    $result = mysqli_query($conex, $query);
    $juego = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Juego - Full Juegos</title>
    <link rel="stylesheet" href="src/css/editar_juego.css">
    <link rel="icon" href="assets/images/favicon.ico">
</head>
<body>
    <div class="admin-container">
        <h2>Editar Juego</h2>
        <form action="editar_juego.php" method="POST" class="game-form" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $juego['ID']; ?>">
            <input type="text" name="nombre" value="<?php echo $juego['Nombre']; ?>" required>
            <input type="number" name="precio" value="<?php echo $juego['Precio']; ?>" required>
            <div class="imagen-actual">
                <p>Imagen actual:</p>
                <img src="assets/images/juegos/<?php echo $juego['Imagen']; ?>" alt="Imagen actual" style="max-width: 200px;">
            </div>
            <input type="file" name="imagen" accept="image/*">
            <p class="imagen-nota">Deja vacío el campo de imagen si no quieres cambiarla</p>
            <button type="submit">Guardar Cambios</button>
        </form>
        <a href="controlpanel.php" class="back-btn">Volver</a>
    </div>
</body>
</html>
<?php
}
?> 