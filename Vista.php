<?php
// Aqui cargamos las vistas de los formularios
class Vista
{
  //Formulario para el landing
  public static function MuestraLanding()
  {
    include "./frm/frm_landing.php";
  }

  public static function MuestraLogin($data)
  {
    include "./frm/frm_login.php";
  }
  public static function MuestraCatalogo($data, $error)
  {
    include "./frm/frm_catalogo.php";
  }

  public static function MuestraCarrito($data, $error)
  {
    include "./frm/frm_carrito.php";
  }

  public static function MuestraRegistro($data)
  {
    include "./frm/frm_signup.php";
  }

  public static function MuestraBiblioteca($data) //Necesario para que la vista tenga los datos a mostrar 
  {
    include "./frm/frm_biblioteca.php";
  }


  public static function MuestraAdministración($data, $error) //Necesario para que la vista tenga los datos a mostrar 
  {
    include "./frm/frm_administracion.php";
  }

  public static function MuestraPerfil($data, $data1, $error) //Necesario para que la vista tenga los datos a mostrar 
  {
    include "./frm/frm_perfil_usuario.php";
  }

  public static function MuestraPrestar($data, $error)
  {
    include "./frm/frm_prestar.php";
  }
}
