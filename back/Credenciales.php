<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="styleAdmin.css">
    <?php include("headerAdmin.php");?>
    <style>
        body {
            background-color: rgb(204, 203, 221); /* Fondo gris claro */
            color: #333; /* Texto oscuro */
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f8f8f8; /* Fondo gris más claro */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Sombra más suave */
        }

        h1 {
            font-size: 24px;
            margin-top: 50px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        input[type="submit"] {
            background-color: #2471ff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2400ff;
        }
    </style>
    <script>
        function mostrarMensaje() {
            <?php
            if (isset($_SESSION['mensaje'])) {
                echo 'alert("' . $_SESSION['mensaje'] . '");';
                unset($_SESSION['mensaje']); // Limpia el mensaje para que no se muestre nuevamente en recargas de página
            }
            ?>
        }
    </script>
</head>
<body onload="mostrarMensaje()">
<div class="container">
        <h1>¡Bienvenido al Taller de Motos!</h1>
        <img src="../image/Logos/logo_taller_small.png" alt="Sayayin" style="width: 300px; height: auto;">
        <form action="verificar.php" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <input type="submit" value="Iniciar sesión">
        </form>
    </div>
    <?php include("footerAdmin.php");?>
</body>
</html>