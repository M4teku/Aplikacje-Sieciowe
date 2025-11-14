<?php
require_once 'config.php';
require_once 'config_smarty.php';

echo "<h1>Testujemy Smarty...</h1>";

// Sprawdźmy czy ścieżki są dobre
echo "ROOT_PATH: " . _ROOT_PATH . "<br>";
echo "APP_URL: " . _APP_URL . "<br>";

// Test Smarty
try {
    $smarty = getSmarty();
    $smarty->assign('test_var', 'DZIAŁA SMARTY! 🎉');
    $smarty->assign('app_url', _APP_URL);
    $smarty->display('test.tpl');
    echo "<p style='color: green;'>SUKCES! Smarty działa!</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>BŁĄD: " . $e->getMessage() . "</p>";
}
?>