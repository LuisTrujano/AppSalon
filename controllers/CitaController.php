<?php

namespace Controllers;

use Model\AdminCita;
use Model\Establecimiento;
use MVC\Router;
use Model\Servicio;
use Model\Horario;

class citaController{
    public static function index(Router $router){

        // session_start();
        isAuth();


        $router->render('cita/index',[
            'nombre' =>$_SESSION['nombre'],
            'id' =>$_SESSION['id'],
        ]);
    }

    public static function horario(Router $router){

        // session_start();
        isAuth();

        date_default_timezone_set('America/Mexico_City'); 
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha); 

        if( !checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('Location: /404');
        }

        
        //Consultar la base de datos
        
        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio, citas.finaliza, citas.estilista, citas.fecha, citas.lugar ";
        $consulta .= "FROM citas ";
        $consulta .= "LEFT OUTER JOIN usuarios ON citas.usuarioId = usuarios.id ";
        $consulta .= "LEFT OUTER JOIN citasServicios ON citasServicios.citaId = citas.id ";
        $consulta .= "LEFT OUTER JOIN servicios ON servicios.id = citasServicios.servicioId ";
        $consulta .= "WHERE citas.fecha = '${fecha}' AND citas.confirmado = 1";
        $consulta .= " ORDER BY citas.id DESC ";


        $citas = Horario::SQL($consulta);
        $citas2 = AdminCita::SQL($consulta);



        $router->render('cita/horario',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            // 'citas2' => $citas2,
            'fecha' => $fecha
        ]);
    }
}