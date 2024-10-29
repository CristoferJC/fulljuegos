<?php
// Destruye la sesión del usuario y lo redirige al index.html
session_start();
session_destroy();
header("Location: index.html");
exit();
?>