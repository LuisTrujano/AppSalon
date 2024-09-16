<div class="barra">
    <p>Hola: <?php echo $nombre ?? ''; ?></p>

    <a class="boton" href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])){ ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
        <a class="boton" href="/establecimientos">Ver Establecimientos</a>
        <a class="boton" href="/establecimientos/crear">Nuevo Establecimiento</a>
    </div>
<?php }else { ?>
    <div class="barra-servicios">
        <a class="boton" href="/cita">Agendar Cita</a>
        <a class="boton" href="/horarios">Ver Horarios</a>
    </div>
    <?php }?>