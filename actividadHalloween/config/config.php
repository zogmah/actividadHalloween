<?php
$host = 'localhost';
$user = 'root';
$password = '1234';
$database = 'halloween';

$con = mysqli_connect($host, $user, $password, $database);

if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8");
?>
