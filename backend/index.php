<?php 
header("Content-Type: application/json; charset=utf-8;");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require "controllers/RotaController.php";
new RotaController();