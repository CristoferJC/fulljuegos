<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'conexion.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conex, $_GET['id']);
    
    // Verificar si el juego existe antes de eliminar
    $verificar = "SELECT * FROM venta_juegos WHERE ID = '$id'";
    $resultado = mysqli_query($conex, $verificar);
    
    if (mysqli_fetch_array($resultado)) {
        $query = "DELETE FROM venta_juegos WHERE ID = '$id'";
        
        if (mysqli_query($conex, $query)) {
            mysqli_close($conex);
            header("Location: controlpanel.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conex);
        }
    } else {
        echo "El juego no existe";
    }
    
    mysqli_close($conex);
}
?>