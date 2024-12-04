<?php
// Aqui cargamos las vistas de los formularios
class Vista
{
    //Formulario para el landing
    public static function entrar()
    {
        include "./frm/frm_landing.php";
    }
      //Formulario para el login
    public static function inicio()
    {
        include "./frm/frm_login.php";
        
    }
  //Formulario para el registro
    public static function registro()
    {
        include "./frm/frm_signup.php";
    }
}
