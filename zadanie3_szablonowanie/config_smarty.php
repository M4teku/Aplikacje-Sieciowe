<?php

require_once _ROOT_PATH.'/lib/smarty/libs/Smarty.class.php'; 

function getSmarty() {
    $smarty = new Smarty();
    
    // Konfiguracja ścieżek
    $smarty->setTemplateDir(_ROOT_PATH.'/templates/');
    $smarty->setCompileDir(_ROOT_PATH.'/templates_c/');
    $smarty->setCacheDir(_ROOT_PATH.'/cache/');
    $smarty->setConfigDir(_ROOT_PATH.'/configs/');
    
    // Opcjonalne ustawienia (wyłącza zapisywanie w cache)
    $smarty->caching = Smarty::CACHING_OFF;
    $smarty->debugging = false;
    
    // Przypisanie stałych
    $smarty->assign('app_url', _APP_URL);
    $smarty->assign('app_root', _APP_ROOT);
    
    return $smarty;
}
?>