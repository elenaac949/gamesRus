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

  public static function MuestraRegistro($data)
  {
    include "./frm/frm_signup.php";
  }

  public static function MuestraBiblioteca($data) //Necesario para que la vista tenga los datos a mostrar 
  {
    include "./frm/frm_biblioteca.php";
  }


  public static function MuestraAdministración($data) //Necesario para que la vista tenga los datos a mostrar 
  {
    include "./frm/frm_administracion.php";
  }
}
