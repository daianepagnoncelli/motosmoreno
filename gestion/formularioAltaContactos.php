<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/motosmoreno.css">
    <link rel="icon" href="image/Logos/favicon.png" type="image/x-icon">
    <title>Formulario Alta Contacto</title>
    <style>
        h6{
            text-align:center;
            font-size:1.6em;
            color:blue;
            background-color: #d8d5d5;
         
        }
        form{
            width:400px;
            margin:0 auto;
            text-align:center;
        }
    </style>
</head>
<body>
    <?php
    include "header.php";
    ?>
    <h6>ALTA USUARIO</h6>
    <form action="altaContacto.php" method="post">
        <label>nombre:</label><input type="text" name="usuario"><br>
        <label>contraseña:</label><input type="text" name="contrasena"><br>
        <label>fechaExpiración</label><input type="date" name="fechaExpiracion"><br><br>
        <input type="submit" value="añadir contacto">
    </form>
    <?php
    include "footer.php";
    ?>

</body>
</html>