<?php
require_once _ROOT_PATH.'/app/libs/Smarty.class.php';

function getSmarty() {
    $smarty = new Smarty();
    $smarty->setTemplateDir(_ROOT_PATH.'/app/');
    $smarty->setCompileDir(_ROOT_PATH.'/templates_c/');
    $smarty->setCacheDir(_ROOT_PATH.'/cache/');
    $smarty->setConfigDir(_ROOT_PATH.'/configs/');
    $smarty->caching = Smarty::CACHING_OFF;
    $smarty->assign('app_url', _APP_URL);
    $smarty->assign('app_root', _APP_ROOT);
    return $smarty;
}
?>