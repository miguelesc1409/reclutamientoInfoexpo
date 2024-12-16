<?php
// Configuración de conexión
$host = "sql5.freemysqlhosting.net";
$dbname = "sql5752133";
$username = "sql5752133";
$password = "i348Fyw8eC";
$port = 3306;

try {
    // Crear instancia de PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Inicializar variables
$id = $nombre = $apellido = $telefono = $fechaNacimiento = $email = $password = $categoria = "";
$isEdit = false;

// Verificar si se está editando un visitante
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $isEdit = true;

    // Cargar datos del visitante
    $sql = "SELECT * FROM visitante WHERE IdVisitante = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $visitante = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($visitante) {
        $nombre = $visitante['Nombre'];
        $apellido = $visitante['Apellidos'];
        $telefono = $visitante['Telefono'];
        $fechaNacimiento = $visitante['FechaNacimiento'];
        $email = $visitante['Email'];
        $password = ""; // No mostrar contraseña por seguridad
        $categoria = $visitante['Categoria'];
    }
}

// Obtener categorías
$sql = "SELECT * FROM categoria";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['registro_nombre'];
    $apellido = $_POST['registro_apellido'];
    $telefono = $_POST['registro_telefono'];
    $fechaNacimiento = $_POST['registro_fecha'];
    $email = $_POST['registro_email'];
    $categoria = $_POST['registro_categoria'];

    if ($isEdit) {
        // Actualizar visitante existente
        $sql = "UPDATE visitante SET Nombre = :nombre, Apellidos = :apellido, Telefono = :telefono, FechaNacimiento = :fecha, Email = :email, Categoria = :categoria WHERE IdVisitante = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        // Insertar nuevo visitante
        $sql = "INSERT INTO visitante (Nombre, Apellidos, Telefono, FechaNacimiento, Email, Password, Categoria) VALUES (:nombre, :apellido, :telefono, :fecha, :email, :password, :categoria)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    }

    // Vincular parámetros
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $fechaNacimiento, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);

    // Ejecutar consulta
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error al guardar los datos.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $isEdit ? "Editar Visitante" : "Registrar Visitante"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
            position: absolute;
            top: 0;
        }
        header a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .login-container {
            background-color: gray;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        .input-group {
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        .input-group .form-control {
            margin-right: 10px;
        }
        .input-group .form-control:last-child {
            margin-right: 0;
        }
    </style>
    
</head>
<body>
<header>
    <div>
        <a href="#">Logo Evento</a>
    </div>
    <div>
        <h3>HEADER</h3>
    </div>
    <div>
        &nbsp;
    </div>
</header>
<div class="login-container">
    <h1><?php echo $isEdit ? "Editar Visitante" : "Registro"; ?></h1>
    <form action="controller_visitante.php<?php echo $isEdit ? '?id=' . $id : ''; ?>" method="POST" onsubmit="return validarEmail() && validarPassword()">
        <div class="input-group">
            <input type="text" name="registro_nombre" class="form-control rec" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            <input type="text" name="registro_apellido" class="form-control rec" placeholder="Apellidos" value="<?php echo htmlspecialchars($apellido); ?>" required>
        </div>
        <div class="input-group">
            <input type="text" name="registro_telefono" class="form-control rec" placeholder="Teléfono" value="<?php echo htmlspecialchars($telefono); ?>" required>
            <input type="date" name="registro_fecha" class="form-control rec" placeholder="Fecha de nacimiento" value="<?php echo htmlspecialchars($fechaNacimiento); ?>" required>
        </div>
        <div class="input-group">
            <input type="email" name="registro_email" class="form-control rec" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="input-group">
            <input type="password" name="registro_password1" class="form-control rec" placeholder="Contraseña" <?php echo $isEdit ? '' : 'required'; ?>>
            <input type="password" name="registro_password2" class="form-control rec" placeholder="Confirmar contraseña" <?php echo $isEdit ? '' : 'required'; ?>>
        </div>
        <div class="input-group">
            <select name="registro_categoria" class="form-control rec" required>
                <option value="">Selecciona una categoría</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat['idCategoria']; ?>" <?php echo ($isEdit && $cat['idCategoria'] == $categoria) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary"><?php echo $isEdit ? "Guardar Cambios" : "Registrarse"; ?></button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function validarEmail() {
        const email = document.getElementById("registro_email").value;
        // Expresión regular para validar email
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(email)) {
            alert("Por favor, ingrese un email válido.");
            return false; // Evitar el envío del formulario
        }
        return true; // Permitir el envío del formulario
    }

    function validarPassword() {
        const password = document.getElementById("registro_password1").value;
        if (password.length < 8) {
            alert("La contraseña debe tener al menos 8 caracteres.");
            return false; // Evitar el envío del formulario
        }
        return true; // Permitir el envío del formulario
    }

</script>
</body>
</html>