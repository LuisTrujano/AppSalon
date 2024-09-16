<?php

namespace Model;

class Cita extends ActiveRecord{

    //Base de datos
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id','fecha','hora','lugar','estilista','finaliza','usuarioId','confirmado'];

    public $id;
    public $fecha;
    public $hora;
    public $lugar;
    public $estilista;
    public $finaliza;
    public $usuarioId;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->lugar = $args['lugar'] ?? '';
        $this->estilista = $args['estilista'] ?? '';
        $this->finaliza = $args['finaliza'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '0';
        
    }
}