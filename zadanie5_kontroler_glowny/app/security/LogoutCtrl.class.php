<?php
namespace app\security;

class LogoutCtrl {
    public function process(){
        session_start();
        session_destroy();
        header("Location: ".\getConf()->app_url."/ctrl.php?action=login");
        exit();
    }
}