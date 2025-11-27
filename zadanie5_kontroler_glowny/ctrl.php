<?php
require_once 'init.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

switch ($action) {
    case 'calcCompute':
        $ctrl = new app\controllers\CalcCtrl();
        $ctrl->process();
        break;
    case 'creditCompute':
        $ctrl = new app\controllers\CreditCtrl();
        $ctrl->process();
        break;
    case 'login':
        $ctrl = new app\security\LoginCtrl();
        $ctrl->process();
        break;
    case 'logout':
        session_destroy();
        header("Location: " . getConf()->app_url . "/ctrl.php");
        exit();
        break;
    case 'creditView':
        $ctrl = new app\controllers\CreditCtrl();
        $ctrl->generateView();
        break;
    default:
        if (empty($_SESSION['role'])) {
            $ctrl = new app\security\LoginCtrl();
            $ctrl->generateView();
        } else {
            $ctrl = new app\controllers\CalcCtrl();
            $ctrl->generateView();
        }
        break;
}