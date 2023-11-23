<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulario Modificar Contacto</title>
<link rel="stylesheet" href="styleAdmin.css">
<link rel="StyleSheet" type="text/css" href="FormModificarContacto.css">

<style>
    
*{
    box-sizing:border-box;
    font-family:    sans-serif;
}
    

h6{
    font-size: 30px;
    color:black;
    text-align:center;
}

    
form {
    font-family: sans-serif;
    width: 1000px;
    right: 1000px;
    padding: 16px;
    border-radius: 10px;
    margin: 0 auto 150px auto;
    background-color: #ccc;
    column-count: 2; /* Divide o conteúdo em duas colunas */
    column-gap: 20px; /* Espaçamento entre as colunas */
}    
    

form label{
    text-align: right;
    width:100px;
	font-weight:bold;
	display:inline;
}

form input[type="text"],
form input[type="email"],
form input[type="number"],
form input[type="date"],
form input[id="Estado"] {
	width:100%;
	padding:3px 10px;
	border:1px solid #f6f6f6;
	border-radius:3px;
	background-color:#f6f6f6;
	margin:8px 0;
	display:inline;
    text-align: center;
}

form input[type="submit"]{
	width:100%;
	padding:8px 16px;
	margin-top:32px;
	border:1px solid #000;
	border-radius:3px;
    background-color: #f6f6f6;
    margin: 8px 0;
	display:inline;
	color:#fff;
	background-color:#4d82d1;
    text-align: center;
} 

form input[type="submit"]:hover{
	cursor:pointer;
}

textarea{
	width:100%;
	height:100px;
	border:1px solid #f6f6f6;
	border-radius:3px;
	background-color:#f6f6f6;			
	margin:8px 0;
	resize:none;
	display:block;
}

#botton{
background-color: blue;        
}

.footer{
    margin-bottom: 0;
    
}

       
    
</style>    
    
    
</head>
<body>
    <?php include("headerAdmin.php");?>
    <?php
    /*inicializar la variables con valores vacios*/
    $Id="";
    $Estado="";
    $Fecha="";
    $NombreApellidos="";
    $Email="";
    $Telefono="";
    $MarcaModelo="";
    $hora="";
    $Motivo="";

    /*sino me ha llegado nada por parametro a traves del metodo POST*/
    if(($_POST==null) || (!isset($_POST['Id']))){
            echo "lo sentimos, pero no se puede llamar a este fichero directamente";
        }
        /*si me llegan datos por metodo post*/
        else{
            $conexion=new mysqli("localhost","usuariocp","usuario*1","reservas");
            $conexion->set_charset("utf8"); 
            
            $consulta="select * from citaprevia where Id='".$_POST['Id']."'; ";
        
            if ($listado=$conexion->query($consulta)){
        
               $registro=$listado->fetch_object();
               $Id=$registro->Id;
               $Estado=$registro->Estado;
               $Fecha=$registro->Fecha;
               $NombreApellidos=$registro->NombreApellidos;
               $Email=$registro->Email;
               $Telefono=$registro->Telefono;
               $MarcaModelo=$registro->MarcaModelo;
               $Hora=$registro->Hora;
               $Motivo=$registro->Motivo;
    
            }else{
                echo "ha habido algun error";
 
                if ($conexion->query($consulta)){
                    echo "el contacto se ha modificado de la tabla";
                }else{
                echo "ha habido algun error";
            }
        }
    }
    ?>
    <h6>MODIFICAR CITAS</h6>
            <div class="center">
            <form action="ModificarContacto.php" method="POST">
                <label>Id:</label><input type="text" name="Id" value='<?php echo $Id; ?>'></br>
                <label>Estado:</label>
                    <!-- <select name="Estado" id="Estado" onchange="this.form.submit();"> -->
                    <select name="Estado" id="Estado">
                        <option default value='$Estado'><!<?php echo $Estado; ?></option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Rechazada">Rechazada</option>
                        <option value="aceptada">Aceptada</option> 
                    </select><br>
                <label>Fecha: </label><input type="date" name="Fecha" value='<?php echo $Fecha; ?>'><br>         
                <label>Nombre y apellidos:</label><input type="text" name="NombreApellidos" value='<?php echo $NombreApellidos; ?>'> <br>
                <label>Email:</label> <input type="text" name="Email" value='<?php echo $Email; ?>'><br>
                <label>Telefono:</label><input type="number" name="Telefono" value='<?php echo $Telefono; ?>'><br>
                <label>Marca y Modelo:</label><input type="text" name="MarcaModelo" value='<?php echo $MarcaModelo; ?>'><br>
                <label>Hora:</label><input type="text" name="Hora" value='<?php echo substr($Hora,0,strlen($Hora)-3); ?>'><br>
                <label>Motivo:</label> <input type="text" name="Motivo" value='<?php echo $Motivo; ?>'><br><br>
                <input type="submit" name="Enviar Datos" id="boton">
            </form>
            </div>
    <?php include("footerAdmin.php");?>
</body>
</html>