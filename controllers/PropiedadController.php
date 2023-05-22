<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController{
    public static function index(Router $router){

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades'=> $propiedades,
            'resultado'=> $resultado,
            'vendedores'=> $vendedores
        ]);
    }

    public static function crear(Router $router){

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $resultado=null;
        //Arreglo con mensajes de errores
         $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //-------Crear una nueva instancia---------
            $propiedad = new Propiedad($_POST['propiedad']);
        
        
            //-------Subida de Archivos-------------
           
        
             //Generar un nombre único
             $nombreImagen = md5( uniqid(rand(), true)) . ".jpg";
        
             //Setear la imagen
                //Realiza un resize a la imagen con intervention
                if($_FILES['propiedad']['tmp_name']['imagen'])  
                {
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    $propiedad->setImagen($nombreImagen);    
                }
                
            //debugear(CARPETA_IMAGENES);
            //Validar
            $errores = $propiedad->validar();    
            if (empty($errores)) {
        
                //Crear la carpeta para subir imagenes
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
               
                //Guarda la Imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
        
                //Guarda en la base de datos
                $propiedad->guardar();
        
                
                
            }           
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router){
       $id = validarORedireccionar('/admin');

       $propiedad = Propiedad::find($id);

       $errores = Propiedad::getErrores();
       $vendedores = Vendedor::all();

    //Metodo POST para actualizar
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        //Asignar los tributos
        $args =$_POST['propiedad'];
    
        $propiedad->sincronizar($args);
    
        //debugear($propiedad);
    
        //Validacion
        $errores = $propiedad->validar();
    
    
         //Generar un nombre único
         $nombreImagen = md5( uniqid(rand(), true)) . ".jpg";
    
        //Subida de Archivos
        if($_FILES['propiedad']['tmp_name']['imagen'])  
        {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);    
        }
    
    
        if (empty($errores)) {
            if($_FILES['propiedad']['tmp_name']['imagen'])  
            {
            //Almacenar la imagen
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
            $propiedad-> guardar();
    
        
        
        }
    
    
       
    }

       $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
            
       ]);
    }

    public static function eliminar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //Validar id
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);
        
                if ($id) {
        
                    $tipo = $_POST['tipo'];
        
                    if(ValidarTipoContenido($tipo))
                        {
                            $propiedad = Propiedad::find($id);
                            $propiedad -> eliminar();
                        }
                   
        
                }
            }
        }
    }
}