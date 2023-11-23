<?php 
if($_POST == null){
    echo "lo sentimos pero no se puede llamar a este fichero directamente";
}
else{
    /*conexion a la base de datos*/
    $conexion=new mysqli("localhost","usuariocp","usuario*1","reservas");
    $conexion->set_charset("utf8"); 

    /*variables que recogen los valores pasados por metodo POST*/

    $Id=$_POST["Id"]; 
    $Estado=$_POST["Estado"];
    $Fecha=$_POST["Fecha"];
    $NombreApellidos=$_POST["NombreApellidos"];
    $Email=$_POST["Email"];
    $Telefono=$_POST["Telefono"];
    $MarcaModelo=$_POST["MarcaModelo"];
    $Hora=$_POST["Hora"];
    $Motivo=$_POST["Motivo"];

    /*consulta sql actualizar registros a traves del formulario*/

    $consulta="UPDATE citaprevia SET Estado='$Estado',Fecha='$Fecha',NombreApellidos='$NombreApellidos',Email='$Email',Telefono='$Telefono',MarcaModelo='$MarcaModelo',Hora='$Hora',Motivo='$Motivo' where Id='$Id'";
    // if ($Estado=="aceptada"){
    // echo $Estado.'se ha enviado un correo de confirmacion';
    // }elseif{
    //     echo "se ha rechazado la cita";
    // }
    if($conexion->query($consulta)){
        echo "contacto actualizado";
        header("Location: listadoCalendario.php");
        exit();

    }else{
        echo "Ha Habido un error";
    }
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     // Recoge los datos del formulario
    //     $Id = $_POST["Id"];
        
    
    //     // Aquí puedes realizar la verificación de los datos, por ejemplo, verificar en una base de datos si el usuario y la contraseña son válidos.
    
    //     // Si los datos son válidos, redirige de nuevo a la página principal
    //     if ($Id == "usuario_valido" && $contrasena == "contrasena_valida") {
    //         header("Location: pagina1.php");
    //         exit();
    //     } else {
            
           
    // echo "Credenciales inválidas. Inténtalo de nuevo.";
    //     }
    
}
?>