<?php
// Inicia la sesión del usuario
session_start();

// Se verifica si el usuario está autenticado, si no lo lleva al login.html
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conex, $_POST['nombre']);
    $precio = mysqli_real_escape_string($conex, $_POST['precio']);
    
    // Verificar si el juego ya existe
    $check_query = "SELECT * FROM venta_juegos WHERE Nombre = '$nombre'";
    $check_result = mysqli_query($conex, $check_query);
    $juego_existente = mysqli_fetch_array($check_result, MYSQLI_ASSOC);
    
    if ($juego_existente) {
        $_SESSION['error'] = "Ya existe un juego con ese nombre";
        header("Location: controlpanel.php");
        mysqli_close($conex);
        exit();
    }
    
    // Si no existe, continuar con la inserción del juego
    // Se verifica si se ha subido una imagen
    if (isset($_FILES['imagen'])) {
        $imagen = $_FILES['imagen'];
        // Se crea un nombre para la imagen usando timestamp
        $nombre_imagen = time() . '_' . $imagen['name'];
        // Se define la ruta donde se guardará la imagen
        $ruta_destino = "assets/images/juegos/" . $nombre_imagen;
        
        if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
            $query = "INSERT INTO venta_juegos (Nombre, Precio, Imagen) VALUES ('$nombre', '$precio', '$nombre_imagen')";
            
            // Se ejecuta la consulta y se verifica si fue exitosa
            if (mysqli_query($conex, $query)) {
                mysqli_close($conex);
                header("Location: controlpanel.php");
                exit();
            } else {
                echo "Error al agregar el juego: " . mysqli_error($conex);
                mysqli_close($conex);
            }
        } else {
            echo "Error al subir la imagen";
            mysqli_close($conex);
        }
    }
}
mysqli_close($conex);
?> 