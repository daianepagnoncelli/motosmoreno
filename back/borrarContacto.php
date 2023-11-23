<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>borrarContacto</title>

</head>
<body>
    <?php
        
    if(($_POST==null) || (!isset($_POST['Id']))){
            echo "lo sentimos, pero no se puede llamar a este fichero directamente";
        }else{
        $conexion=new mysqli("localhost","usuariocp","usuario*1","reservas");
        $conexion->set_charset("utf8"); 
       
            $consulta="Delete from citaprevia where Id='".$_POST['Id']."'; ";
            if ($conexion->query($consulta)){
            echo "el contacto se ha borrado de la tabla";
        }else{
            echo "ha habido algun error";
        }
    }
        
        

    ?>
    <a href="listadoCalendario.php">volver</a>
</body>
</html>