<h1 class="nombre-pagina">Nuevo Establecimiento</h1>
<p class="descripcion-pagina">Llena todos los campos para añadir un nuevo establecimiento</p>

<?php
include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/establecimientos/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Guardar Ubicacion">
</form>