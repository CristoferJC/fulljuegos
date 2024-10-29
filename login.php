<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM venta_login WHERE user = '$username' AND pass = '$password'";
    $result = mysqli_query($conex, $query);
    
    if (mysqli_num_rows($result) == 1) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['username'] = $username;
        header("Location: controlpanel.php");
        exit();
    } else {
        mysqli_close($conex);
        // Credenciales incorrectas
        echo "<script>
                alert('Usuario o contraseña incorrectos.');
                window.location.href = 'login.html';
              </script>";
    }
}
?>
