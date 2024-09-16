<?php
namespace Model;

class Usuario extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','email','password',
    'telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    //Mensajes de validacion para la creacion de cuentas
    public function validarNuevaCuenta(){
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }

        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }

        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La contraseña debe tener minimo 6 caracteres';
        }

        return self::$alertas;
    }

    public function validarLogin(){
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es obligatorio';
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]= 'La contraseña es obligatoria';
        }
        if(strlen(!$this->password) < 6){
            self::$alertas['error'][]= 'La contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    //revision de usuarios
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla ." WHERE email = '" . $this->email."' LIMIT 1";
        // debuguear($query);
        $resultado = self::$db->query($query);
        if($resultado->num_rows){
            self::$alertas['error'][]='El usuario ya esta registrado';
        }
        return $resultado;
        // debuguear($resultado);
    }

    public function hashPassword(){
        $this->password = password_hash($this->password,PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);
        
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Contraseña Incorrecta o la cuenta no ah confirmado su correo';
        }else{
            return true;
        }
    }
}