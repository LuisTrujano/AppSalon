<?php

namespace Controllers;

use Classes\Email;
use Model\Cita;
use Model\CitaServicio;
use Model\Establecimiento;
use Model\Servicio;
use MVC\Router;

class APIEsController{
    public static function index(){

        $establecimientos = Establecimiento::all();
        echo json_encode($establecimientos);
    }


    
}