<?php
// Aqui cargamos las vistas de los formularios
class Vista
{
  //Formulario para el landing
  public static function MuestraLanding()
  {
    include "./frm/frm_landing.php";
  }

  public static function MuestraLogin()
  {
    include "./frm/frm_login.php";
  }
}
