<?php 
header("Content-Type: application/json; charset=utf-8;");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS');
header("Access-Control-Allow-Headers: *");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require "controllers/RotaController.php";
new RotaController();