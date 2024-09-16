<h1 class="nombre-pagina">Confirmar Cita</h1>
<p class="descripcion-pagina">Añade la duracion del servicio y confirme la cita</p>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>

<?php

// include_once __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="formulario">

<?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Confirmar Cita">
</form>