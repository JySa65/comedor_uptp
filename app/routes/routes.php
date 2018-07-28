<?php 
use framework\route\Routes;

new Routes([
    "/" => "IndexController",
    "account" => "AccountController",
    "data" => "DataController",
    "reporte" => "ReporteController",
    "dayforget" => "DayForgetController" 
])

?>