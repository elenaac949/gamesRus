<?php
class Vista
{
    public static function entrar()
    {
        include "./frm/frm_landing.php";
    }
    public static function inicio()
    {
        include "./frm/frm_login.php";
    }

    public static function registro()
    {
        include "./frm/frm_signup.php";
    }
}
