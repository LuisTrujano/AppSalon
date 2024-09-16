<h1 class="nombre-pagina">Ver Horario</h1>

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
        echo "<h2>No Hay Citas en esta fecha</h2>";
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
            <p>Hora: <span><?php echo date("g:i A", strtotime($cita->hora)); ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
            <p>Estilista: <span><?php echo $cita->estilista; ?></span></p>
            <p>Ubicacion: <span><?php echo $cita->lugar; ?></span></p>
            <p>Finaliza: <span><?php echo date("g:i A", strtotime($cita->finaliza)); ?></span></p>
            <?php 
                $idCita = $cita->id;
                }//Fin de IF 
                $total += $cita->precio;
            ?>
        <?php 
        $actual = $cita->id;
        $proximo = $citas[$key + 1]->id ?? 0;

        if(esUltimo($actual, $proximo)){?>
            <?php } 
         }//FIN DE FOREACH ?>
    </ul>
    
</div>

<?php
$script = "<script src='build/js/buscador.js'></script>"
?>