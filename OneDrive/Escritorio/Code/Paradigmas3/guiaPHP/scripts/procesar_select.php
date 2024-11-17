<?php
$nombre = $_POST['nombre'];
$ingresos = $_POST['ingresos'];

echo "Nombre: $nombre<br>";
if ($ingresos == "3001+") {
    echo "Debe pagar impuestos.";
} else {
    echo "No debe pagar impuestos.";
}
?>
