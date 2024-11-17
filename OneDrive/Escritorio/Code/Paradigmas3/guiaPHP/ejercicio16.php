<?php
$archivo = fopen("pedidos.txt", "r");
while (($linea = fgets($archivo)) !== false) {
    echo nl2br($linea);
}
fclose($archivo);
?>
