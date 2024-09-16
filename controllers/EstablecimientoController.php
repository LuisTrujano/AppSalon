<?php

namespace Controllers;

use Model\Establecimiento;
use Model\Servicio;
use MVC\Router;

class EstablecimientoController{
    public static function index(Router $router){

        //deberia iniciar sesion aqui pero como ya esta definido al inicio no es necesario
        isAdmin();
          
        $establecimientos = Establecimiento::all();

        $router->render('establecimientos/index',[
            'nombre' => $_SESSION['nombre'],
            'establecimientos' => $establecimientos
        ]); 
    }

    public static function crear(Router $router){
        // session_start();
        isAdmin();
        $establecimiento = new Establecimiento();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $establecimiento->sincronizar($_POST);
            $alertas = $establecimiento->validar();

            if(empty($alertas)) {
                $establecimiento->guardar();
                header('Location: /establecimientos');
            }
        }

        $router->render('establecimientos/crear',[
            'nombre' => $_SESSION['nombre'],
            'establecimiento' => $establecimiento,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        // session_start();
        isAdmin();
        if(!is_numeric($_GET['id'])) return;
        $establecimiento = Establecimiento::find($_GET['id']);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $establecimiento->sincronizar($_POST);

            $alertas = $establecimiento->validar();
            if(empty($alertas)){
                $establecimiento->guardar();
                header('Location: /establecimientos');
            }
        }

        $router->render('establecimientos/actualizar',[
            'nombre' => $_SESSION['nombre'],
            'establecimiento' => $establecimiento,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        // session_start();
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $establecimiento = Establecimiento::find($id);
            $establecimiento->eliminar();
            header('Location: /establecimientos');
        }
    }
}