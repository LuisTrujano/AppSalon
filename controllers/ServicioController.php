<?php

namespace Controllers;

use Model\Establecimiento;
use Model\servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){

        //deberia iniciar sesion aqui pero como ya esta definido al inicio no es necesario
        isAdmin();
          
        $servicios = servicio::all();

        $router->render('servicios/index',[
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]); 
    }

    public static function crear(Router $router){
        // session_start();
        isAdmin();
        $servicio = new servicio;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear',[
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        // session_start();
        isAdmin();
        if(!is_numeric($_GET['id'])) return;
        $servicio = servicio::find($_GET['id']);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();
            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar',[
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        // session_start();
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $servicio = servicio::find($id);
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}