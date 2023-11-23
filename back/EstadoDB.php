<?php 

include "AccesoBBDD.php";

if($_POST == null){
    echo "lo sentimos pero no se puede llamar a este fichero directamente";
    
}else{

if (isset($_POST['Estado']) && isset($_POST['id'])) {
    
//    echo $_POST['Estado'];
//    
//    echo " y";
//    
//    echo $_POST['id'];

    $consulta="UPDATE citaprevia SET Estado='".$_POST['Estado']."'  WHERE Id='".$_POST['id']."';";


    if($conexion->query($consulta)){
//        echo "El contacto se ha modificado a la tabla";
    }else{
        echo "Ha Habido un error";
    }
    
    }else{
        echo "Error";
    }
}

?>