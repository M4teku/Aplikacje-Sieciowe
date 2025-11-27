<?php
require_once dirname(__FILE__).'/../config.php';
require_once _ROOT_PATH.'/app/security/check.php';

// Załaduj kontroler
require_once _ROOT_PATH.'/app/CreditCtrl.class.php';

// Utwórz obiekt i użyj
$ctrl = new CreditCtrl();
$ctrl->process();
?>