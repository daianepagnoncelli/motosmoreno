<?php
include("AccesoBBDD.php");

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
    $fecha = $_POST["fecha"];
    $nombreApellido = $_POST["NombreApellido"];  // Nombre del campo en el formulario corregido
    $email = $_POST["Email"];
    $telefono = $_POST["Telefono"];
    $marcaModelo = $_POST["Marca"];  // Nombre del campo en el formulario corregido
    $hora = $_POST["hora"];
    $mensaje = $_POST["motivo"]; // Cambio de "motivo" a "mensaje"
    $estado = "Pendiente"; // Estado inicial

    // Verificar que la fecha tenga el formato correcto
    $fecha_parts = explode('/', $fecha);

    if (count($fecha_parts) == 3) {
        $fecha_correcta = $fecha_parts[2] . "-" . $fecha_parts[1] . "-" . $fecha_parts[0];

        // Verificar si los campos requeridos están presentes
        if (!empty($nombreApellido) && !empty($marcaModelo)) {
            // Insertar cita en la base de datos
            $insertarCita = $conexion->prepare("INSERT INTO citaprevia (Estado, Fecha, NombreApellidos, Email, Telefono, MarcaModelo, Hora, Motivo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $insertarCita->bind_param("ssssssss", $estado, $fecha_correcta, $nombreApellido, $email, $telefono, $marcaModelo, $hora, $mensaje);

            if ($insertarCita->execute()) {
                // La cita se registró correctamente
                $mensaje = "Cita registrada exitosamente.";
            } else {
                // Error al registrar la cita
                $mensaje = "Error al registrar la cita. Por favor, inténtalo de nuevo.";
            }
        } else {
            // Algunos campos requeridos están vacíos
            $mensaje = "Por favor, complete todos los campos requeridos.";
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
<body>
    <main>
        
        <article class="izquierdo">
        <div class="mes-navegacion">
            <div class="mesAnterior">
                <a href="?f=<?= $mes_anterior; ?>" class="boton-mes">&lt; Mes Anterior</a>
            </div>
            <div class="mesSiguiente">
                <a href="?f=<?= $mes_siguiente; ?>" class="boton-mes">Mes Siguiente &gt;</a>
            </div>
        </div>
        <div id="current-date">
            <?php
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            
            $mes = date("m", strtotime($fecha));
            $anio = date("Y", strtotime($fecha));
            ?>

            <?php
            echo $anio_actual;
            ?>
            <br>
            <?php
            echo " " . $meses[intval($mes_actual) - 1];
            ?>
        </div>
        <a href="login.php" class="boton-login">Iniciar sesión como administrador</a>
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
                    $clickableClass = ($estadoDia === "NoDisponible" || $estadoDia === "Reservado") ? "no-click" : "";

                    // Imprimir el día en el calendario
                    echo "<li class='day $class $clickableClass' onclick='seleccionarFecha($day, this)'>
                            $day
                            <div class='$classCSS'>$disponibilidad</div>
                        </li>";

                    // Incrementar el día
                    $day++;
                }
                ?>
            </ol>
        </section>
    </article>
    <article class="derecho">
        <div class="cita_info">
        <div class="contenedor">
            <!-- Muestra el mensaje de confirmación si existe -->
            <?php
            if (!empty($mensaje)) {
                echo "<script>alert('$mensaje'); window.location.href = 'calendario.php';</script>";
            }
            ?>

            <form method="post" action="">
                <span style="font-style: italic; font-size: large; font-weight: 600;">Reserva</span>
                <span>Por favor, seleccione los días en el calendario.</span>
                <!-- <label for="fecha" class="required">Fecha seleccionada:</label> -->
                <input type="hidden" id="fecha" name="fecha" value="<?php echo date('d/m/Y', strtotime($fecha)); ?>">

                <label for="NombreApellido" class="required">Nombre y Apellidos:</label>
                <input type="text" id="NombreApellidos" name="NombreApellidos" required>

                <label for="Email" class="required">Email:</label>
                <input type="email" name="Email" id="Email" required />

                <label for="Telefono" class="required">Teléfono:</label>
                <input type="text" id="Telefono" name="Telefono">

                <label for="MarcaModelo" class="required">Marca y Modelo:</label>
                <input type="text" id="MarcaModelo" name="MarcaModelo" required>

                <label for="hora" class="required">Seleccione la hora de su visita:</label>
                <select name="hora" id="hora" required style="width:100px">
                    <option value="09:00:00">09:00 AM</option>
                    <option value="10:00:00">10:00 AM</option>
                    <option value="11:00:00">11:00 AM</option>
                    <option value="12:00:00">12:00 PM</option>
                    <option value="13:00:00">01:00 PM</option>
                </select>

                <label for="motivo">Indique el motivo de la reserva:</label>
                <textarea id="motivo" name="motivo" rows="4" cols="50"></textarea>

                <div class="terminos-container">
                    <input type="checkbox" name="terminos" id="terminos" onchange="" required>
                    <p class="required">Acepto los términos y las condiciones</p>
                </div>

                <input class="submit" type="submit" value="Reserva ahora" name="submit">
            </form>
        </div>
    </article>
















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

    var parts = fechaActual.split("/");
    var dia = day < 10 ? "0" + day : day;
    var mes = parts[1];
    var año = parts[2];

    var fechaSeleccionada = dia + "/" + mes + "/" + año;
    fechaInput.value = fechaSeleccionada;

    casillasCalendario = document.querySelectorAll("li");
    casillasCalendario.forEach(function (casilla) {
        casilla.classList.remove("current-day");
    });
    element.classList.add("current-day");
}

// Agregar el evento de clic a las casillas del calendario
var casillasCalendario = document.querySelectorAll("li");
casillasCalendario.forEach(function (casilla) {
    casilla.addEventListener("click", function () {
        // Obtener el día (como número) del contenido de la casilla
        var day = parseInt(casilla.textContent, 0);

        // Llamar a la función para seleccionar la fecha y pasar el elemento actual
        seleccionarFecha(day, casilla);

        // Cambiar la clase de las casillas para resaltar la fecha seleccionada
        casillasCalendario.forEach(function (c) {
            c.classList.remove("current-day");
        });
        casilla.classList.add("current-day");
    });
});
</script>