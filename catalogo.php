<?php
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo - Full Juegos</title>
    <link rel="stylesheet" href="src/css/catalogo.css">
    <link rel="icon" href="assets/images/favicon.ico">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="assets/images/logo.jpg" alt="Full Juegos Logo">
            </div>
            
            <div class="search-container">
                <form class="search-form" onsubmit="return false;">
                    <input type="search" id="searchInput" placeholder="Buscar juegos...">
                </form>
                <div id="resultados-busqueda" class="resultados-busqueda"></div>
            </div>

            <nav>
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="catalogo.php">Catalogo</a></li>
                    <li><a href="login.html">Iniciar sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="catalogo-section">
            <h2>Catálogo de Juegos</h2>
            <div class="juegos-grid">
                <?php
                $query = "SELECT * FROM venta_juegos";
                $result = mysqli_query($conex, $query);
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="juego-card">';
                    // Se verifica si hay una imagen, si no se usa una imagen por defecto
                    $rutaImagen = $row['Imagen'] ? 'assets/images/juegos/' . $row['Imagen'] : 'assets/images/juegos/default.jpg';
                    echo '<img src="'.$rutaImagen.'" alt="'.$row['Nombre'].'">';
                    echo '<h3>'.$row['Nombre'].'</h3>';
                    echo '<p class="precio">'.number_format($row['Precio'], 0, ',', '.').' CLP</p>';
                    echo '<a href="comprar.html"><button class="buy-button">Comprar</button></a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>
    </main>
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Acerca de Full Juegos</h4>
                    <ul>
                        <li><a href="sobre-nosotros.html">Sobre nosotros</a></li>
                        <li><a href="contacto.html">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Ayuda</h4>
                    <ul>
                        <li><a href="preguntas.html">Preguntas frecuentes</a></li>
                        <li><a href="politica.html">Política de devoluciones</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <span id="currentYear"></span> Full Juegos. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    <script src="src/js/year.js"></script>
    <script src="src/js/search-catalogo.js"></script>
</body>
</html>
