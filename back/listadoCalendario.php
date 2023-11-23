<?php
$conexion = new mysqli("localhost", "usuariocp", "usuario*1", "reservas");
$conexion->set_charset("utf8");
$consulta = "select * from citaprevia;";
$listado = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="styleAdmin.css">
    <style>
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        
        h6{
            font-size: 30px;
            color:black;
            text-align:center;
        }


        table {
            width: 80%;
            top:0;
            margin:auto;
            border-collapse: collapse;

    
        }

        th {
            background-color: #007acc;
            color: #fff;
            text-align: center;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        img {
            width: 25px;
            margin-top: 10px;
            cursor: pointer;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 2px solid #007acc;
            padding: 10px;
            z-index: 9999;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9998;
        }

        .overlay.active, .popup.active {
            display: block;
        }

        

        /* Agrega estilos para los círculos de estado */
         .estado-column {
            width: 10px;
        } 

        .estado-circle {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .circle-pendiente {
            background-color: orange;
        }

        .circle-aceptada {
            background-color: red;
        }

        .circle-rechazada {
            background-color: black;
        } */

    </style>
    <script>
        function showPopup(message) {
            document.querySelector(".popup").style.display = "block";
            document.querySelector(".overlay").style.display = "block";
            document.querySelector(".popup").innerText = message;
        }

        function closePopup() {
            document.querySelector(".popup").style.display = "none";
            document.querySelector(".overlay").style.display = "none";
        }
    </script>
</head>
<body>
    <?php include("headerAdmin.php");?>
   
        <h6>Panel de Administrador</h6>
    

    <table>
        <tr>
            <th>Modificar</th>
            <th>Borrar</th>
            <th>Id</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Nombre y Apellidos</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Marca Modelo</th>
            <th>Hora</th>
            <th>Motivo</th>
        </tr>
        <?php
        while ($registro = $listado->fetch_object()) {
            echo "<tr><td>";
        ?>

        <form id="<?php echo "modificar" . $registro->Id; ?>" action="FormularioModificarContacto.php" method="post">
            <input type="hidden" name="Id" value="<?php echo $registro->Id; ?>">
            <img src="modificar2.png" onclick="document.getElementById('<?php echo 'modificar' . $registro->Id; ?>').submit();">
        </form>

        <?php
        echo "</td><td>";
        ?>

        <form id="<?php echo "papelera" . $registro->Id; ?>" action="borrarContacto.php" method="post">
            <input type="hidden" name="Id" value="<?php echo $registro->Id; ?>">
            <img src="papelera2.png" onclick="document.getElementById('<?php echo 'papelera' . $registro->Id; ?>').submit();">
        </form>

        <?php
        echo "</td>";
        echo "<td>$registro->Id</td>";
        echo "<td><div class='estado-circle " . strtolower($registro->Estado) . "'></div>";
        echo "<p>" . ucfirst($registro->Estado) . "</p></td>";
        if ($registro->Fecha != null) {
            echo "<td>" . date('d/m/Y', strtotime($registro->Fecha)) . "</td>";
        } else {
            echo "<td></td>";
        }
        echo "<td>$registro->NombreApellidos</td>";
        echo "<td>$registro->Email</td>";
        echo "<td>$registro->Telefono</td>";
        echo "<td>$registro->MarcaModelo</td>";
        echo "<td>$registro->Hora</td>";
        echo "<td><button onclick='showPopup(\"$registro->Motivo\");'>Ver Mensaje</button></td></tr>";
        echo "<br/>";
        }
        ?>
    </table>

    <div class="popup"></div>
    <div class="overlay" onclick="closePopup();"></div>

   

   <?php include("footerAdmin.php");?>

    <script>
        var sound = document.getElementById("notificationSound");
        sound.volume = 0.2; // Ajusta el volumen según sea necesario

        function playNotificationSound() {
            sound.currentTime = 0;
            sound.play();
        }
    </script>
</body>
</html>
