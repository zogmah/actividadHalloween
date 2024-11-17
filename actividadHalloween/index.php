<?php
session_start();
include 'config/config.php'; 

// Consultar disfraces
$query = "SELECT * FROM disfraces WHERE eliminado = 0";
$result = mysqli_query($con, $query);

// Manejo de votos
if (isset($_POST['votar'])) {
    $id_disfraz = (int)$_POST['id_disfraz'];
    $id_usuario = $_SESSION['id_usuario'] ?? 0; 

    if (!$id_usuario) {
        echo "<script>alert('Debes iniciar sesión para votar.');</script>";
    } else {
        // Verificar si el usuario ya votó por este disfraz
        $check_voto = "SELECT * FROM votos WHERE id_usuario = $id_usuario AND id_disfraz = $id_disfraz";
        $voto_existente = mysqli_query($con, $check_voto);

        if (mysqli_num_rows($voto_existente) > 0) {
            echo "<script>alert('Ya votaste por este disfraz.');</script>";
        } else {
            // Registrar el voto
            mysqli_query($con, "INSERT INTO votos (id_usuario, id_disfraz) VALUES ($id_usuario, $id_disfraz)");
            mysqli_query($con, "UPDATE disfraces SET votos = votos + 1 WHERE id = $id_disfraz");
            echo "<script>alert('¡Voto registrado con éxito!');</script>";
        }
    }
}

// Registro de usuarios
if (isset($_POST['registrar'])) {
    $nombre = mysqli_real_escape_string($con, $_POST['username']);
    $clave = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO usuarios (nombre, clave) VALUES ('$nombre', '$clave')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Usuario registrado con éxito.');</script>";
    } else {
        echo "<script>alert('Error al registrar usuario.');</script>";
    }
}

// Inicio de sesión
if (isset($_POST['login'])) {
    $nombre = mysqli_real_escape_string($con, $_POST['username']);
    $clave = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE nombre = '$nombre'";
    $result_user = mysqli_query($con, $query);

    if ($result_user && mysqli_num_rows($result_user) === 1) {
        $user = mysqli_fetch_assoc($result_user);
        if (password_verify($clave, $user['clave'])) {
            $_SESSION['id_usuario'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            echo "<script>alert('Inicio de sesión exitoso.');</script>";
        } else {
            echo "<script>alert('Contraseña incorrecta.');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.');</script>";
    }
}

// Agregar disfraces desde el panel de administración
if (isset($_POST['agregar_disfraz'])) {
    $nombre = mysqli_real_escape_string($con, $_POST['costume-name']);
    $descripcion = mysqli_real_escape_string($con, $_POST['costume-desc']);

    // Manejo del archivo de imagen
    $foto = $_FILES['foto'];
    $nombre_foto = time() . "_" . basename($foto['name']);
    $ruta_destino = "imagenes/" . $nombre_foto;

    if (move_uploaded_file($foto['tmp_name'], $ruta_destino)) {
        $query = "INSERT INTO disfraces (nombre, descripcion, votos, foto, eliminado) VALUES ('$nombre', '$descripcion', 0, '$ruta_destino', 0)";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Disfraz agregado exitosamente.');</script>";
        } else {
            echo "<script>alert('Error al agregar el disfraz.');</script>";
        }
    } else {
        echo "<script>alert('Error al subir la imagen.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Concurso de Disfraces</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <nav class="navigation">
        <ul>
            <li><a href="#disfraces">Explorar Disfraces</a></li>
            <li><a href="#register">Crear Cuenta</a></li>
            <li><a href="#login">Acceder</a></li>
            <li><a href="#admin-panel">Administrar</a></li>
        </ul>
    </nav>
    <header class="hero">
        <h1>¡Participa en el Concurso de Disfraces!</h1>
    </header>
    <main>
        <!-- Sección de Disfraces -->
        <section id="disfraces" class="content-section">
            <h2>Galería de Disfraces</h2>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="costume">
                <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                <img src="<?php echo htmlspecialchars($row['foto']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" style="max-width: 100%; height: auto;">
                <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                <p>Votos: <?php echo htmlspecialchars($row['votos']); ?></p>
                <form method="POST">
                    <input type="hidden" name="id_disfraz" value="<?php echo $row['id']; ?>">
                    <button class="vote-btn" type="submit" name="votar">¡Votar!</button>
                </form>
            </div>
            <?php } ?>
        </section>

        <!-- Registro de Usuario -->
        <section id="register" class="content-section">
            <h2>Crear una Cuenta</h2>
            <form method="POST">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="registrar">Registrarse</button>
            </form>
        </section>

        <!-- Inicio de Sesión -->
        <section id="login" class="content-section">
            <h2>Acceso</h2>
            <form method="POST">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login">Iniciar Sesión</button>
            </form>
        </section>

        <!-- Panel de Administración -->
        <section id="admin-panel" class="content-section">
            <h2>Panel de Administración</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="costume-name">Nombre del Disfraz</label>
                <input type="text" id="costume-name" name="costume-name" required>

                <label for="costume-desc">Descripción</label>
                <textarea id="costume-desc" name="costume-desc" required></textarea>

                <label for="costume-photo">Foto del Disfraz</label>
                <input type="file" id="costume-photo" name="foto" required>

                <button type="submit" name="agregar_disfraz">Agregar Disfraz</button>
            </form>
        </section>
    </main>
</body>
</html>
