<?php

namespace Model;

class AdminCita extends ActiveRecord {
    protected static $tabla = 'citasServicios';
    protected static $columnasDB = ['id','hora','cliente','email',
    'telefono','servicio','precio','confirmado','estilista','finaliza','fecha','nombre','lugar'];

    public $id;
    public $nombre;
    public $fecha;
    public $hora;
    public $lugar;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;
    public $finaliza;
    public $estilista;
    public $confirmado;

    public function __construct()
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->lugar = $args['lugar'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->finaliza = $args['finaliza'] ?? '';
        $this->estilista = $args['estilista'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
    }
}