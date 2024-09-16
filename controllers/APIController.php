<?php

namespace Controllers;

use Classes\Email;
use Model\Cita;
use Model\CitaServicio;
use Model\Establecimiento;
use Model\Servicio;
use MVC\Router;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);

        // $establecimientos = Establecimiento::all();
        // echo json_encode($establecimientos);
    }

    public static function guardar(){
        
        //Almacena la cita y devuelve ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        //Almacena la cita y el servicio

        $idServicios = explode(",", $_POST['servicios']);

        foreach ($idServicios as $idServicio){
            $args = [
                'citaId' =>  $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        //Regresa respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $cita = Cita::find($id);
            $cita->eliminar();

            $email = new Email($email,$nombre,$id);
            $email->servicioNegado();
            
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public static function confirmar(){
        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $cita = Cita::find($id);

            $email = new Email($email,$nombre,$id);
            $email->servicioAceptado();
            // Sincronizar solo campos específicos
            $camposActualizar = [
                'confirmado' => $_POST['confirmado'] ?? null,
                'finaliza' => $_POST['hora'] ?? null
                // Agrega aquí otros campos que deseas actualizar
            ];
            
            $cita->sincronizar($camposActualizar);

            $alertas = $cita->validar();
            if (empty($alertas)) {
                $cita->guardar();
                header('Location: /admin');
            }
        }

    }
    
}