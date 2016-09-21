<?php
return array(
    //cliente admin para la prueba
    "default_admin_user" => "geocom",
    //Url del sitio
    "base_url" => "http://192.168.240.97:85/",
    //Configuracion Base de datos
    "db" => array(
        "host" => "localhost",
        "database" => "selenium",
        "user" => "root",
        "password" => "geocom"
    ),
    //administradores del sitio
    "admin_users" => array(
        "user" => array(
            "username" => "geocom",
            "password" => "g30c0m!",
        )
    ),
    //Los tipos de alerta que permito loguear
    "log_level" => array("msg","alert","error","success"),
    //clientes configurados para el sitio
    "customers" => array(
        "documentOrEmail" => "80236103",
        "mustHaveConvenios" => true
    ),
    //Con cuantos clientes hago las pruebas en numero o para todos porngo all
    "check_customers" => "all",
    //si checkeo si cargo bien los convenios (es solo para cruz verde y los clientes que quiero checkear tienen que tener mustHaveConvenios en true)
    "check_convenios" => true,
    //urls configuradas en mi sitio para cada accion
    "urls" => array(
        "frontend" => array(
            "createCustomer" => "index.php/customer/account/create/",
            "loginCustomer" => "index.php/customer/account/login",
        ),
        "backend" => array(
            "admin" => "index.php/admin"
        ),
    )
);