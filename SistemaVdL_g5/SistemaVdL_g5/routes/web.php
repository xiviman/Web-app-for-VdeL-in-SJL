<?php
require_once 'app/controllers/SesionController.php';

$sesionController = new SesionController();

if ($_SERVER['REQUEST_URI'] == '/login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $sesionController->login();
} elseif ($_SERVER['REQUEST_URI'] == '/login') {
    include 'app/views/login/login.php';
} elseif ($_SERVER['REQUEST_URI'] == '/logout') {
    $sesionController->logout();
}
?>
