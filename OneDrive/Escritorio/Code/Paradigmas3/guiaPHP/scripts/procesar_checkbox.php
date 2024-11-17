<?php
$nombre = $_POST['nombre'];
$deportes = $_POST['deportes'];

echo "Nombre: $nombre<br>";
echo "Cantidad de deportes seleccionados: " . count($deportes) . "<br>";
?>
