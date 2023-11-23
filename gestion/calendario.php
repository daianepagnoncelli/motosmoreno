<?php
include "AccesoBBDD.php";

// Función para obtener el mes anterior y el siguiente
function obtenerMesesAnteriorSiguiente($fecha) {
    $fecha_actual = strtotime($fecha);
    $mes_anterior = date('Y-m-d', strtotime('-1 month', $fecha_actual));
    $mes_siguiente = date('Y-m-d', strtotime('+1 month', $fecha_actual));
    return array('anterior' => $mes_anterior, 'siguiente' => $mes_siguiente);
}

// Almacena la fecha actual antes de procesar el formulario
$fecha_actual = date("Y-m-d");

// Variables para mensajes de confirmación
$mensaje = ""; // Inicialmente, el mensaje está vacío

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
       
    // Validación y recopilación de datos del formulario
    $fecha = $_POST["Fecha"];
    $nombreApellido = $_POST["NombreApellidos"];
    $email = $_POST["Email"];
    $telefono = $_POST["Telefono"];
    $marcaModelo = $_POST["Marca"];
    $hora = $_POST["Hora"];
    $mensaje = $_POST["Motivo"]; // Cambio de "motivo" a "mensaje"
    $estado = "Pendiente"; // Estado inicial
        
   // }

    // Verificar que la fecha tenga el formato correcto
    $fecha_parts = explode('/', $fecha);

    if (count($fecha_parts) == 3) {
        $fecha_correcta = $fecha_parts[2] . "-" . $fecha_parts[1] . "-" . $fecha_parts[0];

        // Insertar cita en la base de datos
        $insertarCita = $conexion->prepare("INSERT INTO citaprevia (Estado, Fecha, NombreApellido, Email, Telefono, Marca, Hora, motivo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $insertarCita->bind_param("ssssssss", $estado, $fecha_correcta, $nombreApellido, $email, $telefono, $marcaModelo, $hora, $mensaje);
        
        if ($insertarCita->execute()) {
            // La cita se registró correctamente
            $mensaje = "Cita registrada exitosamente.";
        } else {
            // Error al registrar la cita
            $mensaje = "Error al registrar la cita. Por favor, inténtalo de nuevo.";
        }
    }
}

// Obtener la fecha actual o la fecha seleccionada
if (isset($_GET["f"])) {
    $fecha = $_GET["f"];
} else {
    if (isset($_POST["fecha"]) && preg_match('/\d{2}\/\d{2}\/\d{4}/', $_POST["fecha"])) {
        // Si se envió el formulario con una fecha válida, úsala
        $fecha = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["fecha"]))); // Convierte el formato de fecha
    } else {
        $fecha = date("Y-m-d");
    }
}

// Obtener el mes y año actual
$mes_actual = date("m", strtotime($fecha));
$anio_actual = date("Y", strtotime($fecha));

// Obtener el mes y año del mes anterior y siguiente
$meses_anteriorsiguientes = obtenerMesesAnteriorSiguiente($fecha);
$mes_anterior = $meses_anteriorsiguientes['anterior'];
$mes_siguiente = $meses_anteriorsiguientes['siguiente'];

// Obtener el número de días en el mes y el día de la semana en el que comienza el mes
$numDays = cal_days_in_month(CAL_GREGORIAN, $mes_actual, $anio_actual);
$firstDayOfWeek = date('N', strtotime("$anio_actual-$mes_actual-01"));

// Generar los elementos del calendario
$daysInWeek = 7;
$day = 1;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Calendario</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
</head>
<body >
<main>
     <?php
         include "header.php";
        ?>
    <article class="izquierdo" style='background:white;width:100%;margin-top:35px;'>
         <div class="mes-navegacion">
            <a href="?f=<?= $mes_anterior; ?>" class="boton-mes">&lt; Mes Anterior</a>
            <a href="?f=<?= $mes_siguiente; ?>" class="boton-mes">Mes Siguiente &gt;</a>
        </div>
         
      
        <div id="current-date">
            
            <?php
             
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            
            $mes = date("m", strtotime($fecha));
            $anio = date("Y", strtotime($fecha));
            echo $mes;
            ?>
<!--    chiva("$mes");-->
            <?php
//            echo $anio_actual;
            ?>
            <br>
            <?php
            echo " " . $meses[intval($mes_actual) - 1];
            ?>
        </div>

        <section>

            <ol>
                <li class="day-name no-click">Lunes</li>
                <li class="day-name no-click">Martes</li>
                <li class="day-name no-click">Miércoles</li>
                <li class="day-name no-click">Jueves</li>
                <li class="day-name no-click">Viernes</li>
                <li class="day-name no-click">Sábado</li>
                <li class="day-name no-click">Domingo</li>
                <?php

                // Rellenar los espacios en blanco antes del primer día del mes
                for ($i = 1; $i < $firstDayOfWeek; $i++) {
                    echo "<li class='no-click'></li>";
                }

                // Generar los elementos del calendario
               while ($day <= $numDays) {
    // Calcular la clase para el día actual
    $class = ($day == date('j', strtotime($fecha))) ? "current-day" : "";

    // Obtener la disponibilidad para el día
    $fechaConsulta = "$anio_actual-$mes_actual-$day";
    $consultaDisponibilidad = $conexion->prepare("SELECT NumeroPlazas FROM disponibilidad WHERE Fecha = ?");
    $consultaDisponibilidad->bind_param("s", $fechaConsulta);
    $consultaDisponibilidad->execute();
    $consultaDisponibilidad->bind_result($numeroPlazas);
    $consultaDisponibilidad->fetch();
    $consultaDisponibilidad->close();
                   
                  // echo $numeroPlazas;
                   
                   if(is_null($numeroPlazas)){
                       
                         $fechaConsulta = "$anio_actual-$mes_actual-$day";
                        $habilitarFechas = $conexion->prepare("insert into disponibilidad (Fecha, NumeroPlazas)
                                                                                            values(?,3);");
                        $habilitarFechas->bind_param("s", $fechaConsulta);
                        $habilitarFechas->execute();
                        $habilitarFechas->bind_result($numeroPlazas);
                        $habilitarFechas->fetch();
                        $habilitarFechas->close();
                   }
                   
                   
                   
                   
                   
                   

    // Calcular el estado y la clase CSS para el día   
    $estadoDia = '';
    $classCSS = '';
    if (is_null($numeroPlazas)) {
        $disponibilidad = "No Disponible";
        $classCSS = "no-disponible";
        $estadoDia = "NoDisponible";
    } elseif ($numeroPlazas == 0) {
        $disponibilidad = "Reservado";
        $classCSS = "reservado";
        $estadoDia = "Reservado";
    } else {
        $disponibilidad = "Disponibles: $numeroPlazas";
        $classCSS = "disponibilidad";
        $estadoDia = "Disponible";
    }

    // Verificar si el día es clickeable
    $clickableClass = ($estadoDia === "NoDisponible" || $estadoDia === "Reservado") ? "" : "";

   

                   
    // Mostrar los datos para el día actual
    echo "<li class='day $class $clickableClass' onclick='seleccionarFecha($day, this)'>
        
        $day
        <div style='width:100%;' onclick=\"editarDisponibilidad('divVisible$day');\" ondblclick=\"ocultarDisponibilidad('divVisible$day');\">
            <div style='margin-bottom:-85px;'  class='$classCSS'>$disponibilidad</div>
            <form id='$day' action='disponibilidad.php' method='POST'>
                <input type='hidden' value='$fechaConsulta' name='fecha'></input>
                <div id='divVisible$day' style='visibility:hidden;'>  
                    <input type='number' value='$numeroPlazas' name='diasDisponibles' style='width:30px;'/>
                    <input type='submit'></input> 
                </div>
            </form>
        </div>
    </li>";

   
    $day++;
}

                
                ?>
            </ol>
        </section>
    </article>
 <?php
         include "footer.php";
        ?>
</main>
</body>
</html>

<script>
    
   
// Función para redirigir después de mostrar el mensaje
function redirigirDespuesDelMensaje() {
    window.location.href = "calendario.php";
}

// Verificar si hay un mensaje y esperar 3 segundos antes de redirigir
if ('<?php echo $mensaje; ?>' !== '') {
    setTimeout(redirigirDespuesDelMensaje, 0); // Redirigir después de 3 segundos
}

// Función para manejar el clic en las casillas del calendario
    function seleccionarFecha(day, element) {
    var fechaInput = document.querySelector("input[name='fecha']");
    var fechaActual = fechaInput.value;
        
     if (!fechaActual || fechaActual.indexOf("/") === -1) {
        // Puedes manejar el caso de fecha no válida de alguna manera, como mostrar un mensaje de error.
        console.log("Fecha no válida.");
        return;
    }

    var parts = fechaActual.split("/");
    var dia = day < 10 ? "0" + day : day;
    var mes = parts[1];
    var año = parts[2];
        
      

    var fechaSeleccionada = dia + "/" + mes + "/" + año;
    fechaInput.value = fechaSeleccionada;

    // Elimina la clase "current-day" de todas las casillas del calendario.
    var casillasCalendario = document.querySelectorAll("li");
    casillasCalendario.forEach(function (casilla) {
        casilla.classList.remove("current-day");
    });

    // Agrega la clase "current-day" a la casilla seleccionada.
    element.classList.add("current-day");
}

// Agregar el evento de clic a las casillas del calendario
var casillasCalendario = document.querySelectorAll("li");
casillasCalendario.forEach(function (casilla) {
    casilla.addEventListener("click", function () {
        // Obtener el día (como número) del contenido de la casilla
        var day = parseInt(casilla.textContent, 0);
        
        //alert(casilla);

        // Llamar a la función para seleccionar la fecha y pasar el elemento actual
        seleccionarFecha(day, casilla);

        // Cambiar la clase de las casillas para resaltar la fecha seleccionada
        casillasCalendario.forEach(function (c) {
            c.classList.remove("current-day");
        });
        casilla.classList.add("current-day");
    });
});
    
    function editarDisponibilidad(capa){
        
      document.getElementById(capa).style.visibility = 'visible';
       
    }
    
    
    function ocultarDisponibilidad(capa){
        
          document.getElementById(capa).style.visibility = 'hidden';
        
    }
    
    function chiva(param){
        
        // alert(param);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</script>