<?php 

include "AccesoBBDD.php";

if($_POST == null){
    echo "lo sentimos pero no se puede llamar a este fichero directamente";
    
}else{

if (isset($_POST['diasDisponibles']) && isset($_POST['fecha'])) {
    
    echo $_POST['diasDisponibles'];
    echo $_POST['fecha'];

    $consulta="UPDATE disponibilidad SET NumeroPlazas='".$_POST['diasDisponibles']."' WHERE Fecha='".$_POST['fecha']."';";

    if($conexion->query($consulta)){
            
        echo "actualizado";
        header('Location:calendario.php');
    }   
 }
}

?>