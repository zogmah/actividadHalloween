<?php
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$pizzas = $_POST['pizzas'];

$archivo = fopen("pedidos.txt", "a");
fwrite($archivo, "Nombre: $nombre\nDirección: $direccion\n");
fwrite($archivo, "Pizzas: " . implode(", ", $pizzas) . "\n");
fwrite($archivo, "-------------------------\n");
fclose($archivo);

echo "Pedido guardado.";
?>
