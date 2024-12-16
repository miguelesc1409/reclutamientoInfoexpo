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


// Obtener categorías
$sql = "SELECT * FROM categoria";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar formulario
if ($_POST['registro_password1'] == $_POST['registro_password2']){
    if(strlen($_POST['registro_password1']) >= 8){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['registro_nombre'];
            $apellido = $_POST['registro_apellido'];
            $telefono = $_POST['registro_telefono'];
            $fechaNacimiento = $_POST['registro_fecha'];
            $email = $_POST['registro_email'];
            $password = md5($_POST['registro_password1']);
            $categoria = $_POST['registro_categoria'];
        
            
                $sql = "INSERT INTO visitante (Nombre, Apellidos, Telefono, FechaNacimiento, Email, contrasenia, Categoria) VALUES (:nombre, :apellido, :telefono, :fecha, :email, :password, :categoria)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        

            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fechaNacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        

            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                echo "<script>alert('Error al guardar los datos.'); window.history.back();</script>";
            }
        }
    }else{
        if ($stmt->execute()) {    
        echo "<script>alert('La contraseña es menor a 8'); window.history.back();</script>";
            exit;
        }
    }
}else{
    if ($stmt->execute()) {
    echo "<script>alert('La contraseñas no coinciden'); window.history.back();</script>";
    exit;
    }
}

?>

