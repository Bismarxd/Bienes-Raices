<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = true;
        $router->render('paginas/index', [
           
           'propiedades' => $propiedades,
           'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', 
        [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        //busca la propiedad por su id
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
         ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog', [
            
         ]);
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $respuestas = $_POST['contacto'];
           
            //Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            //Configurar smtp
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io'; 
            $mail->SMTPAuth = true;
            $mail->Username = '440823f1e180c1';
            $mail->Password   = 'f093b62433e0db'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 2525; 
            
            //Configurar el contenido del email
            $mail->setFrom('admin@bienesreices.com');
            $mail->addAddress('admin@bienesreices.com', 'BienesRaices.com');     //Add a recipient
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            //Hailitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un Nuevo Mensaje</p>';
            $contenido .= '<p>Nombre:  ' . $respuestas['nombre']  . ' </p>';
            

            //Eniciar de forma condicional algunos campos de Email o Telefono
            if ($respuestas['contacto'] === 'telefono') 
            {
                $contenido .= '<p>Eligió ser contactado por Teléfono:</p>';
                $contenido .= '<p>Teléfono:  ' . $respuestas['telefono']  . ' </p>';
                $contenido .= '<p>Fecha Contacto:  ' . $respuestas['fecha']  . ' </p>';
                $contenido .= '<p>Hora:  ' . $respuestas['hora']  . ' </p>';
            }else
            {
                //Es Email, entonces agregamos el campo de Email
                $contenido .= '<p>Eligió ser contactado por Email:</p>';
                $contenido .= '<p>Email:  ' . $respuestas['email']  . ' </p>';
            }


            
            $contenido .= '<p>Mensaje:  ' . $respuestas['mensaje']  . ' </p>';
            $contenido .= '<p>Vende o Compra:  ' . $respuestas['tipo']  . ' </p>';
            $contenido .= '<p>Precio o Presupuesto:  $  ' . $respuestas['precio']  . ' </p>';
            $contenido .= '<p>Prefiere ser Contactado Por:  ' . $respuestas['contacto']  . ' </p>';
           
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es un texto alternativo sin HTML';

            //Enviar em Email
            if ($mail->send()) 
            {
                $mensaje = "Mensaje Enviado Correctamente";
            }else
            {
                $mensaje = "El Mensaje no se Pudo Enviar";
            }
        }
        $router->render('paginas/contacto',[
            'mensaje' => $mensaje
        ]);
    }
}