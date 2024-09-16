<?php

namespace Model;

class Establecimiento extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'lugar';
    protected static $columnasDB = ['id','ubicacion'];

    public $id;
    public $ubicacion;

    public function __construct($args = [])
    {
        $this->id= $args['id'] ?? null;
        $this->ubicacion = $args['ubicacion'] ?? '';
    }

    public function validar(){
        if(!$this->ubicacion){
            self::$alertas['error'][] = 'El nombre del servicio es obligatorio';

        }

        return self::$alertas;
    }
}