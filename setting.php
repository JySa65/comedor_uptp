<?php 

define('BASE_DIR', __DIR__);
session_save_path(BASE_DIR . "/temp");

// config time and places
setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8');
date_default_timezone_set('America/Caracas');
// end time


// Config .env
$dotenv = new \Dotenv\Dotenv(BASE_DIR);
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'SECRET_KEY', 'TEMPLATE_DIR']);
// end .env

define('NAME_PROJECT', '/' . explode("/", $_SERVER['PHP_SELF'])[1] . '/');
define('APP_DIR', BASE_DIR . "/app/");
define('TEMPLATES_DIR', BASE_DIR . "/public/");
define('STATIC_DIR', NAME_PROJECT . "static/");
define('DB_HOST', $_SERVER['DB_HOST']);
define('DB_USER', $_SERVER['DB_USER']);
define('DB_PASSWORD', $_SERVER['DB_PASSWORD']);
define('DB_NAME', $_SERVER['DB_NAME']);
define('DB_CONNECTOR', $_SERVER['DB_CONNECTOR']);

?>