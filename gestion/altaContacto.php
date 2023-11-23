<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
        if($_POST == null){
            echo "lo sentimos pero no se puede llamar a este fichero directamente";
        }
        else{
            $conexion=new mysqli("localhost","usuariocp","usuario*1","reservas");
            $conexion->set_charset("utf8"); 
            $usuario=$_POST["usuario"];  
            $contrasena=$_POST["contrasena"];
            $fechaExpiracion=$_POST["fechaExpiracion"];
            $consulta="insert into administradores(usuario,contrasena,fechaExpiracion) values ('$usuario','$contrasena','$fechaExpiracion')";
            
            if($conexion->query($consulta)){
                echo "El contacto se ha añadido a la tabla";
            }else{
                echo "Ha Habido un error";
            }
        }
    ?>
</body>
</html>