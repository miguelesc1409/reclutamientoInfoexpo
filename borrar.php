<?php session_start(); 
if (isset($_SESSION['user'])):
    if ($_SESSION['rol']=='Admin'):
  ?>

<?php
// Configuración de conexión
$host = "sql5.freemysqlhosting.net";
$dbname = "sql5752133";
$username = "sql5752133";
$password = "i348Fyw8eC";
$port = 3306;

try {
    // Crear una instancia de PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el ID del visitante a borrar
    $id = $_GET['id'];

    // Consulta para borrar el visitante
    $sql = "DELETE FROM visitante WHERE IdVisitante = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirigir después de eliminar
    header("Location: index.php"); // Cambia a tu archivo que lista los visitantes
    exit;
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
<?php else:
echo "<script>alert('Acción no autorizada'); window.history.back();</script>";
endif;
else:
    header("Location: login.php");
endif;?>