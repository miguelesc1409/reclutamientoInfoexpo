<?php session_start(); 
if (isset($_SESSION['user'])):
  ?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reclutamiento</title>
    <link href="reclutamiento.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  
  <body>
    <header>
      <div>
          <a href="#">Logo Evento</a>
      </div>
      <h1>Listado visitantes (Evento)</h1>
      <div>
          <a href="logout.php">Cerrar Sesión</a>
      </div>
  </header>
<div>
  <button class="btn btn-dark" onclick="window.location.href='visitante.php'">✏️ Nuevo</button>
</div>
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

    // Consulta SELECT
    $sql = "SELECT * FROM visitante v INNER JOIN categoria c on c.idCategoria = v.categoria order by v.IdVisitante";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Obtener todos los registros
    $visitantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar resultados en una tabla
    echo "<div>
        <table class='table'>";
    echo "<thead>
              <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Nombre</th>
                <th scope='col'>Apellidos</th>
                <th scope='col'>Email</th>
                <th scope='col'>Teléfono</th>
                <th scope='col'>Nacimiento</th>
                <th scope='col'>Categoria</th>
                <th scope='col'></th>
              </tr>
            </thead><tbody>";
    
    foreach ($visitantes as $visitante) {
        echo "<tr>";
        echo "<th scope='row'>" . htmlspecialchars($visitante['IdVisitante']) . "</td>";
        echo "<td>" . htmlspecialchars($visitante['Nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($visitante['Apellidos']) . "</td>";
        echo "<td>" . htmlspecialchars($visitante['Email']) . "</td>";
        echo "<td>" . htmlspecialchars($visitante['Telefono']) . "</td>";
        echo "<td>" . htmlspecialchars($visitante['FechaNacimiento']) . "</td>";
        echo "<td>" . htmlspecialchars($visitante['nombre']) . "</td>";
        echo '<td class="actions">
                  <button class="btn btn-warning" onclick="window.location.href=\'visitante.php?id=' . $visitante['IdVisitante'] . '\'">✏️ Editar</button>
              <button class="btn btn-danger" onclick="if(confirm(\'¿Estás seguro de que deseas borrar este visitante?\')) { window.location.href=\'borrar.php?id=' . $visitante['IdVisitante'] . '\' }">🗑️ Borrar</button>
              </td>';
        echo "</tr>";
    }

    echo "</table> </tbody>
          </table>";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>

    
            
            
                
            
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<?php else:
print_r($_SESSION);
  header("Location: login.php");
endif;?>

