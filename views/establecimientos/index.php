<h1 class="nombre-pagina">Establecimientos</h1>
<p class="descripcion-pagina">Administracion de Establecimientos</p>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>

<ul class="servicios">
    <?php foreach($establecimientos as $establecimiento){ ?>
        <li>
            <p>Nombre: <span><?php echo $establecimiento->ubicacion ;?></span></p>

            <div class="acciones">
                <a class="boton" href="/establecimientos/actualizar?id=<?php echo $establecimiento->id; ?>">Actualizar</a>
                <form action="/establecimientos/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $establecimiento->id; ?>">
                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
            </div>
        </li>
    
    <?php } ?>
    
</ul>