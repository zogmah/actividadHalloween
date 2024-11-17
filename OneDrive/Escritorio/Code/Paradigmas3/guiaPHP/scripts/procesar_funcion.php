<?php
function verificarClaves($clave1, $clave2) {
    return $clave1 === $clave2;
}

$clave1 = $_POST['clave1'];
$clave2 = $_POST['clave2'];

if (verificarClaves($clave1, $clave2)) {
    echo "Claves coinciden.";
} else {
    echo "Claves no coinciden.";
}
?>
