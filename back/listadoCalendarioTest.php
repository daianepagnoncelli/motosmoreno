<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        th{
            background-color:red;
        }
        th,td{
            border:2px solid black;
        }
    </style>
	<script>
        
        var EstadoSelecc = document.getElementById("Estado");
        var IdRegistro = document.getElementById("id");
        
//        if(EstadoSelecc != null){
             EstadoSelecc.addEventListener("change", function() {
             var Estado = EstadoSelecc.value;        
             var selectedId = IdRegistro;    
            });        
        //}
        
	</script>
</head>
<body>
   
     
    <?php

	    include "AccesoBBDD.php";
    	
        $consulta="select * from citaprevia;";
        $listado=$conexion->query($consulta);?>
       
        <table cols="9" sytle="boder:solir 1px black;">
            <tr><th>id</th><th>Estado</th><th>Fecha</th><th>Nombre y Apellidos</th><th>Email</th><th>Telefono</th><th>Marca Modelo</th><th>Hora</th><th>Motivo</th>
        <?php
        while ($registro=$listado->fetch_object()){ 
            echo "<tr><td>$registro->Id</td>";
			
            echo "<td>
				 <form id='EstadoForm' method='POST' action='EstadoDB.php'>            
                  <select id='Estado' name='Estado' onchange='this.form.submit()'>
                  <option default value='$registro->Estado'>$registro->Estado</option>
					<option value='1'>Pendiente</option>
					<option value='2'>Rechazada</option>
					<option value='3'>Aceptada</option>
				  </select> 
                   <input type='hidden' name='id' id='id' value='$registro->Id'>
                </form>         
			</td>";
			
            if ($registro->Fecha!=null){
                // pasa del formato Año, mes , dia a (d/m/Y)
                echo  "<td>".date('d/m/Y',strtotime($registro->Fecha))."</td>";
            }
            echo "<td>$registro->NombreApellidos</td>";
            echo "<td>$registro->Email</td>";
            echo "<td>$registro->Telefono</td>";
            echo "<td>$registro->MarcaModelo</td>";
            echo "<td>$registro->Hora</td>";
            echo "<td>$registro->Motivo</td>";           
            echo "<br/>";
        }

    ?>
    </table>
</body>
</html>
