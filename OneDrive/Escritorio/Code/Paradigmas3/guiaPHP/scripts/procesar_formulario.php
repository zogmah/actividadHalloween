<?php
$nombre = $_POST['nombre'];
$edad = $_POST['edad'];

echo "Nombre: $nombre<br>";
if ($edad >= 18) {
    echo "Es mayor de edad.";
} else {
    echo "Es menor de edad.";
}
?>
