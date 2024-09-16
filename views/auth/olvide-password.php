<h1 class="nombre-pagina">Olvide Contraseña</h1>
<p class="descripcion-pagina">Reestable tu contraseña escribiendo tu email a continuación </p>
<?php 
include_once __DIR__ ."/../templates/alertas.php";
?>

<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        type="email"
        id="email"
        name="email"
        placeholder="Ingresa tu email"
        />
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear Una</a>
</div>