<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            font-family: sans-serif;
        }
        
        .header{
            background-color: #a4a3a4; 
            padding: 0px;
            text-align: center;
        }
        
        .logo{
            margin-top: 0px auto;
            width: 300px;
            height: 150px;
        }
        
        h6{
            margin-top: 5px;
            text-align:center;
            font-size:1.8em;
        }
        
        table{
            width:80%;
            margin:0 auto;
            border-collapse: collapse;
        }
        
        th{
            background-color: #4d82d1;
            color: white;
        }
        
        th,td{
            width: 50px;
            border: 2px solid black;
            margin: 0 auto;
            text-align: center;
            align-content: center;
        }
        
        td{
            margin:0 auto;
            
        }
        
        img{
            width:25px;
            align-content: center;
            margin-top: 10px;
        }
        
        .footer{
            background-color: a4a3a4;
            position: absolute;
            bottom: 5px;
            width: 99%;
            height: 2.5rem; 
            color: blue;
            text-align: center;
        }
        
    </style>
</head>
<body>
    <?php
        $conexion=new mysqli("localhost","usuariocp","usuario*1","reservas");
        $conexion->set_charset("utf8"); 
        $consulta="select * from citaprevia;";
        $listado=$conexion->query($consulta);?>
        <div class="header"><img class="logo" src="motos_moreno_logo.png"><h6>Lista de Servicios</h6></div>
        
        <table cols="11" sytle="boder:solir 1px black;">
            <th>Modificar</th><th>Borrar</th><th>Id</th><th>Estado</th><th>Fecha</th><th>Nombre y Apellidos</th><th>Email</th><th>Telefono</th><th>Marca Modelo</th><th>Hora</th><th>Motivo</th>
        <?php
        while ($registro=$listado->fetch_object()){ 
            echo "<tr><td>"; ?>

            <form id="<?php echo "modificar".$registro->Id; ?>" action="FormularioModificarContacto.php" method="post">
                <input type="hidden" name="Id" value="<?php echo $registro->Id; ?>">
                <img src="modificar2.png" onclick="document.getElementById('<?php echo 'modificar'.$registro->Id; ?>').submit();">
            </form>

            <?php echo "</td>";
            echo "<td>"; ?>

            <form id="<?php echo "papelera".$registro->Id; ?>" action="borrarContacto1.php" method="post">
                <input type="hidden" name="Id" value="<?php echo $registro->Id; ?>">
                <img src="papelera2.png" onclick="document.getElementById('<?php echo 'papelera'.$registro->Id; ?>').submit();">
            </form>

            <?php echo "</td>";
            echo "<td>$registro->Id</td>";
            echo "<td>$registro->Estado</td>";
            // echo "<td>$registro->Fecha</td>";
            if ($registro->Fecha!=null){
                echo  "<td>".date('d/m/Y',strtotime($registro->Fecha))."</td>";// pasa del formato Año, mes , dia a (d/m/Y)
            }
            // echo "<td>$registro->Fecha</td>";
            echo "<td>$registro->NombreApellidos</td>";
            echo "<td>$registro->Email</td>";
            echo "<td>$registro->Telefono</td>";
            echo "<td>$registro->MarcaModelo</td>";
            echo "<td>$registro->Hora</td>";
            echo "<td>$registro->Motivo</td></tr>";
            
            echo "<br/>";
        }
        // if ($listado->num_rows->0){
        //     echo "tienes datos";
        // }else{
        //     echo "sin datos";
        // }


        // if ($conexion) {
        //     echo "ok";
        // }else{
        //     header("direccion web");
        // }
        



    ?>
    </table>
    <div class="footer"> Motos Moreno - Copyright © 2023 Todos los derechos reservados.</div>
</body>
</html>
