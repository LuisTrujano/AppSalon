<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{
    public static function index( Router $router){

        isAdmin();
        
        date_default_timezone_set('America/Mexico_City'); 
    $fecha = $_GET['fecha'] ?? '';
    $fechas = explode('-', $fecha); 

    // Validar fecha solo si se proporciona
    if($fecha && !checkdate($fechas[1], $fechas[2], $fechas[0])){
        header('Location: /404');
    }

    // Consultar la base de datos
    $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente, citas.fecha, citas.estilista, citas.confirmado, citas.finaliza, citas.lugar, ";
    $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio ";
    $consulta .= " FROM citas ";
    $consulta .= " LEFT OUTER JOIN usuarios ON citas.usuarioId=usuarios.id ";
    $consulta .= " LEFT OUTER JOIN citasServicios ON citasServicios.citaId=citas.id ";
    $consulta .= " LEFT OUTER JOIN servicios ON servicios.id=citasServicios.servicioId ";

    // Si hay fecha, agregar filtro
    if ($fecha) {
        $consulta .= " WHERE fecha = '${fecha}' ";
    } else {
        // Si no hay fecha, ordenar por la más reciente
        $consulta .= " ORDER BY citas.id DESC ";
    }

    $citas = AdminCita::SQL($consulta);



        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }

}