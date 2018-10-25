<?php 
header("Content-Type: application/json; charset=utf-8;");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS');
header("Access-Control-Allow-Headers: *");

require "controllers/RotaController.php";
new RotaController();