<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color:grey;
        }
    </style>
    
</head>
<body>

</body>
</html>
<?php
//    $username = "juan";
//    $password = "1qaz2wsx";
//    $database = "reservas";
$conexion=new mysqli("localhost","usuariocp","usuario*1","reservas");
$conexion->set_charset("utf8"); 
//    $conn = new mysqli($username, $password, $database);

//    if ($conexion->connect_error) {
//        die("Error de conexión a la base de datos: " . $conexion->connect_error);
//    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Realizar la consulta a la base de datos para verificar las credenciales
    $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $result = $conexion->query($consulta);
//    header("Location: listadoCalendario.php");
//    exit();
    
}
    if ($result->num_rows > 0) {
        // Credenciales válidas, redirige al listadoCalendario.php
        header("Location: listadoCalendario.php");
        exit();
    } else {
    //  echo "Credenciales inválidas. Por favor, intenta de nuevo.";
        echo '<div style="color: red;"><script>alert("Credenciales inválidas. Por favor, intenta de nuevo.");</script>.</div>';
        

    //  header("Location: credenciales.php");
    //  exit();
        // echo '<div style="color: red;">Credenciales inválidas. Por favor, intenta de nuevo.</div>';
    }

    $conexion->close();
?>
