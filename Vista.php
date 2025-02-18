<?php

/**
 * Clase Vista
 * 
 * Esta clase se encarga de cargar las vistas de los formularios utilizados en la aplicación.
 */
class Vista
{
    /**
     * Muestra la vista del landing page.
     * 
     * @return void
     */
    public static function MuestraLanding()
    {
        include "./frm/frm_landing.php";
    }

    /**
     * Muestra la vista del formulario de login.
     * 
     * @param mixed $data Datos necesarios para la vista.
     * @return void
     */
    public static function MuestraLogin($data)
    {
        include "./frm/frm_login.php";
    }

    /**
     * Muestra la vista del catálogo.
     * 
     * @param mixed $data Datos del catálogo.
     * @param mixed $data1 Datos adicionales.
     * @param mixed $data2 Datos adicionales.
     * @param mixed $data3 Datos adicionales.
     * @param mixed $error Información de errores.
     * @return void
     */
    public static function MuestraCatalogo($data, $data1, $data2, $data3, $data4,  $error)
    {
        include "./frm/frm_catalogo.php";
    }

    /**
     * Muestra la vista del carrito de compras.
     * 
     * @param mixed $data Datos del carrito.
     * @param mixed $error Información de errores.
     * @param mixed $data1 Datos adicionales.
     * @return void
     */
    public static function MuestraCarrito($data, $error, $data1)
    {
        include "./frm/frm_carrito.php";
    }

    /**
     * Muestra la vista de registro de usuario.
     * 
     * @param mixed $data Datos para la vista de registro.
     * @return void
     */
    public static function MuestraRegistro($data)
    {
        include "./frm/frm_signup.php";
    }

    /**
     * Muestra la vista de la biblioteca del usuario.
     * 
     * @param mixed $data Datos de la biblioteca.
     * @param mixed $data1 Datos adicionales.
     * @param mixed $error Información de errores.
     * @return void
     */
    public static function MuestraBiblioteca($data, $data1, $error)
    {
        include "./frm/frm_biblioteca.php";
    }

    /**
     * Muestra la vista de administración.
     * 
     * @param mixed $data Datos administrativos.
     * @param mixed $data1 Datos adicionales.
     * @param mixed $error Información de errores.
     * @return void
     */
    public static function MuestraAdministración($data, $data1, $error)
    {
        include "./frm/frm_administracion.php";
    }

    /**
     * Muestra la vista del perfil del usuario.
     * 
     * @param mixed $data Datos del perfil.
     * @param mixed $data1 Datos adicionales.
     * @param mixed $error Información de errores.
     * @return void
     */
    public static function MuestraPerfil($data, $data1, $error)
    {
        include "./frm/frm_perfil_usuario.php";
    }

    /**
     * Muestra la vista para la acción de prestar.
     * 
     * @param mixed $data Datos necesarios para la vista.
     * @param mixed $error Información de errores.
     * @return void
     */
    public static function MuestraPrestar($data, $error)
    {
        include "./frm/frm_prestar.php";
    }

    /**
     * Muestra la vista para la acción de regalar.
     * 
     * @param mixed $data Datos necesarios para la vista.
     * @param mixed $error Información de errores.
     * @return void
     */
    public static function MuestraRegalar($data, $error)
    {
        include "./frm/frm_regalar.php";
    }

  public static function MuestraPago($data, $error){
    include "./frm/frm_pago.php";
  }


  public static function MuestraPaginaError($data,$error){
    include "./common/error.php";
  }
}
