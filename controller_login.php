<?php

$host = "sql5.freemysqlhosting.net";
$dbname = "sql5752133";
$username = "sql5752133";
$password = "i348Fyw8eC";
$port = 3306;

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['login_email'];
    $password = md5($_POST['login_password']); 

    $sql = "SELECT * FROM visitante v INNER JOIN categoria c on c.idCategoria = v.categoria 
    WHERE v.Email = :email AND v.Contrasenia = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $visitante = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {

        session_start();
        $_SESSION['user'] = $email;
        $_SESSION['rol'] = $visitante['nombre'];
        
        header("Location: index.php"); 
        exit;
    } else {

        echo "<script>alert('Email o contraseña incorrectos.'); window.history.back();</script>";
    }
}
?>