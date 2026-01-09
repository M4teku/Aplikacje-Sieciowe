<?php
require_once dirname(__FILE__).'/../../config.php';

//inicjacja mechanizmu sesji
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//pobranie roli
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

//jeśli brak parametru to idź na stronę logowania
if (empty($role)){
    header("Location: "._APP_URL."/app/security/login.php");
    exit();
}
// Dodanie globalnej zmiennej $role
$GLOBALS['role'] = $role;
?>