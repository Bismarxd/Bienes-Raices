<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{
    public static function crear(Router $router)
    {
        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            //Crear Una Nueva Instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            //Validar que no haya cambios vacios
            $errores = $vendedor->validar();

            //No hay Errores
                if (empty($errores)) 
                {
                    $vendedor->guardar();
                }

        }


        $router -> render('/vendedores/crear', [
            'errores'=>$errores,
            'vendedor'=>$vendedor
        ]);
    }
    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('/admin');

        //Obtener datos del vendedor a actualizar
        $vendedor = Vendedor::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
   //Asignar los valores
   $args = $_POST['vendedor'];

    //Sincronizar objeto en memoria con loq ue usuario escribio
   $vendedor->sincronizar($args);


   //Validacion
   $errores = $vendedor->validar();


   if (empty($errores))
   {
    $vendedor->guardar();
   }

}

        $router -> render('/vendedores/actualizar', [
            'errores'=>$errores,
            'vendedor'=>$vendedor
        ]);
    }
    public static function eliminar()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') 
            {              
                //valida el id
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if ($id) {
                    //Valida el tipo a Eliminar
                    $tipo = $_POST['tipo'];
        
                    if(ValidarTipoContenido($tipo))
                        {
                            $propiedad = Vendedor::find($id);
                            $propiedad -> eliminar();
                        }
                
        
                }
            }
        }
    }
}