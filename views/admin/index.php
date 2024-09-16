<h1 class="nombre-pagina">Panel de Administración</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>
<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha; ?>"
            />
        </div>
    </form>
</div>
<?php
    if(count($citas) === 0){
        echo "<h2>No hay citas en esta fecha</h2>";
    }
?>

<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
            foreach($citas as $key => $cita){
                if($idCita !== $cita->id){
                    $total = 0;

                    
        ?>
        <li>
            <p>ID: <span><?php echo $cita->id; ?></span></p>
            <p>Fecha: <span><?php echo $cita->fecha; ?></span></p>
            <p>Hora: <span><?php echo date("g:i A", strtotime($cita->hora)); ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
            <p>Lugar: <span><?php echo $cita->lugar; ?></span></p>
            <p>Estilista: <span><?php echo $cita->estilista; ?></span></p>
            <p>Email: <span><?php echo $cita->email; ?></span></p>
            <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
            <p>Finaliza: <span><?php echo date("g:i A", strtotime($cita->finaliza)); ?></span></p> <!--Aqui terminan los datos a mostrar del cliente-->
            <h3>Servicios</h3>
            <?php 
                $idCita = $cita->id;
                }//FIN DE IF
                $total += $cita->precio;
            ?>
            <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio; ?></p> <!--Este codigo muestra 1 o mas servicios solicitados por el cliente-->
            <?php
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0; //Calcula el ultimo array de cita y colocara el precio

                if(esUltimo($actual, $proximo)){ ?>
                    <p class="total">Total: <span>$ <?php echo $total; ?></span></p><!--Muestra el valor final del servicio-->

                    <?php if($cita->confirmado == 0){ //?> 
                    <div class="campo">
                        <form action="/admin/confirmar" method="POST">
                            <input type="time" id="hora" name="hora"/>
                            <input type="hidden" type="number" id="confirmado" name="confirmado" value="1"/>
                            <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                            <input type="hidden" name="nombre" value="<?php echo $cita->cliente; ?>">
                            <input type="hidden" name="email" value="<?php echo $cita->email; ?>">
                            <input type="submit" class="boton" value="Confirmar Cita">
                        </form>
                    </div>
                    <?php } //FIN DEL IF DE CONFIRMADO?>
                    <div class="campo">
                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                            <input type="hidden" name="nombre" value="<?php echo $cita->cliente; ?>">
                            <input type="hidden" name="email" value="<?php echo $cita->email; ?>">
                            <input type="submit" class="boton-eliminar" value="Eliminar">
                        </form>
                    </div>
                <?php
                    } //FIN DEL IF esUltimo
                    }//FIN DE FOREACH
                ?>
    </ul>
</div>

<?php
$script = "<script src='build/js/buscador.js'></script>";
?>
