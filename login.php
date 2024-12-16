<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reclutamiento</title>
    <link href="reclutamiento.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Fondo gris claro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Centrado vertical */
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
            position: absolute; /* Para que el header no afecte el centrado */
            top: 0;
        }
        header a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .login-container {
            background-color: gray; /* Fondo blanco para el formulario */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
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
        <div>&nbsp;</div>
    </header>

    <div class="login-container">
        <h1>Login</h1>
        <form  action="controller_login.php" method="POST">
            <input type="email" name="login_email" id="login_email" class="form-control rec" placeholder="Email" required>
            <br>
            <input type="password" name="login_password" id="login_password" class="form-control rec" placeholder="Contraseña" required>
            <br>
            <div>
                <a href="registro.php" class="buttonr">Registrarse</a>
                <button type="submit" class="buttonr">Acceder</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function validarFormulario() {
            const email = document.getElementById("login_email").value;
            const password = document.getElementById("login_password").value;

            // Validar email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Por favor, ingrese un email válido.");
                return false; // Evitar el envío del formulario
            }

            // Validar contraseña
            if (password.length < 8) {
                alert("La contraseña debe tener al menos 8 caracteres.");
                return false; // Evitar el envío del formulario
            }

            return true; // Permitir el envío del formulario
        }
    </script>
</body>
</html>