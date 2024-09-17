<?php
namespace Classes;


use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //crear el correo
        $mail = new PHPMailer();
        $mail->isSMTP();


        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('scrapidoo224@gmail.com','Black & White Barberia');
        $mail->addAddress($this->nombre, $this->email); //Nombre es el correo y email es el nombre ._.
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .=" <p><strong>Hola " . $this->email . "</strong> Has creado tu cuenta en Black & White Barberia, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . " '>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .="</html>";

        $mail->Body = $contenido;

        //Enviar el correo
        $mail->send();
    }

    public function enviarInstrucciones(){
        //crear el correo
        $mail = new PHPMailer();
        $mail->isSMTP();


        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('scrapidoo224@gmail.com','Black & White Barberia');
        $mail->addAddress($this->email, $this->nombre); //Nombre es el correo y email es el nombre ._.
        $mail->Subject = 'Reestablecer tu contraseña';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .=" <p> <strong> Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu contraseña, click en el enlace para hacerlo </p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . " '>Reestablecer contraseña</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .="</html>";

        $mail->Body = $contenido;

        //Enviar el correo
        $mail->send();
    }

    public function servicioNegado(){
        //crear el correo
        $mail = new PHPMailer();
        $mail->isSMTP();


        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('scrapidoo224@gmail.com','Black & White Barberia');
        $mail->addAddress($this->email, $this->nombre); //Nombre es el nommbre cliente y email correo del cliente
        $mail->Subject = 'Cita no fue aceptada';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .=" <p><strong>Hola: " . $this->nombre . "</strong> Has solicitado una cita en Black & White Barberia <strong>lamentablemente el horario seleccionado no fue aprobado</strong> te recomendamos reagendar tu cita</p>";
        $contenido .= "<p>Gracias por su compresion </p>";
        $contenido .="</html>";

        $mail->Body = $contenido;

        //Enviar el correo
        $mail->send();
    }

    public function servicioAceptado(){
        //crear el correo
        $mail = new PHPMailer();
        $mail->isSMTP();


        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('scrapidoo224@gmail.com','Black & White Barberia');
        $mail->addAddress($this->email, $this->nombre); //Nombre es el nommbre cliente y email correo del cliente
        $mail->Subject = 'Confirmacion de Cita';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .=" <p><strong>Hola: " . $this->nombre . "</strong> has solicitado una cita en Black & White Barberia el horario seleccionado fue aprobado</p>";
        $contenido .="<p>Te solicitamos estar 5 minutos antes de la hora agendada para que tu servicio sea atendido lo mas rapido posible</p>";
        $contenido .= "<p>Gracias por su compresion </p>";
        $contenido .="</html>";

        $mail->Body = $contenido;

        //Enviar el correo
        $mail->send();
    }
}
