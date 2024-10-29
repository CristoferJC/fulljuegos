<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Full Juegos</title>
    <link rel="stylesheet" href="src/css/controlpanel.css">
    <link rel="icon" href="assets/images/favicon.ico">
</head>
<body>
    <div class="admin-container">
        <h1>Panel de Control</h1>
        <div class="admin-actions">
            <h2>Gestión de Juegos</h2>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>
            <form action="agregar_juego.php" method="POST" class="game-form" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="Nombre del juego" required>
                <input type="number" name="precio" placeholder="Precio" required>
                <input type="file" name="imagen" accept="image/*" required>
                <button type="submit">Agregar Juego</button>
            </form>
            
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Buscar juego por nombre..." class="search-input">
            </div>

            <div class="games-list">
                <h3>Juegos Actuales</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Preparar la consulta con ordenamiento
                        $query = "SELECT * FROM venta_juegos ORDER BY ID DESC";
                        $result = mysqli_query($conex, $query);

                        if (!$result) {
                            die("Error en la consulta: " . mysqli_error($conex));
                        }

                        // Mostrar los juegos en la tabla
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            echo "<tr class='game-row'>";
                            echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                            echo "<td class='game-name'>" . htmlspecialchars($row['Nombre']) . "</td>";
                            echo "<td>" . number_format($row['Precio'], 0, ',', '.') . " CLP</td>";
                            echo "<td>
                                    <a href='editar_juego.php?id=" . htmlspecialchars($row['ID']) . "' class='edit-btn'>Editar</a>
                                    <a href='eliminar_juego.php?id=" . htmlspecialchars($row['ID']) . "' class='delete-btn' 
                                       onclick='return confirm(\"¿Estás seguro de eliminar este juego?\")'>Eliminar</a>
                                  </td>";
                            echo "</tr>";
                        }

                        mysqli_close($conex);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="cerrar_sesion.php" class="logout-btn">Cerrar Sesión</a>
    </div>
    <script src="src/js/search.js"></script>
</body>
</html>
