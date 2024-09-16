<?php

namespace Model;


class Horario extends ActiveRecord {
    protected static $tabla = 'citasServicios';
    protected static $columnasDB = ['id','hora','email',
    'telefono','servicio','precio','confirmado','finaliza','estilista','lugar'];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;
    public $lugar;
    public $finaliza;
    public $estilista;
    public $confirmado;

    public function __construct()
    {
        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->lugar = $args['lugar'] ?? '';
        $this->finaliza = $args['finaliza'] ?? '';
        $this->estilista = $args['estilista'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
    }
}