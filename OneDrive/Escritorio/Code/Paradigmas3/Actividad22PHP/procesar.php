<?php
// procesar.php

$servidor = "localhost";  
$usuario = "root";        
$contrasena = "1234";         
$base_de_datos = "act22";

// Crear la conexión
$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);

// Verificar si hay error en la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para verificar si las contraseñas coinciden
function verificar_contraseñas($clave, $clave_confirmada) {
    if ($clave !== $clave_confirmada) {
        return "Las contraseñas no coinciden. Por favor, inténtelo nuevamente.";
    }
    return "";
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $clave = $_POST['clave'];
    $clave_confirmada = $_POST['clave_confirmada'];

    // Verificar si las contraseñas coinciden
    $mensaje_error = verificar_contraseñas($clave, $clave_confirmada);
    
    if ($mensaje_error !== "") {
        // Si las contraseñas no coinciden, mostrar mensaje de error
        echo $mensaje_error;
    } else {
        // Si las contraseñas coinciden, almacenar en la base de datos
        // Encriptar la contraseña antes de almacenarla
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, clave) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre_usuario, $clave_encriptada);

        if ($stmt->execute()) {
            echo "Usuario registrado correctamente.";
        } else {
            echo "Error al registrar al usuario: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
