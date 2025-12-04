<?php
function getFromRequest($param_name){
    return isset($_REQUEST[$param_name]) ? $_REQUEST[$param_name] : null;
}

function forwardTo($action_name){
    getRouter()->setAction($action_name);
    include getConf()->root_path."/ctrl.php";
    exit;
}

function redirectTo($action_name){
    header("Location: ".getConf()->action_url.$action_name);
    exit;
}

function addRole($role){
    getConf()->roles[$role] = true;
    $_SESSION['_roles'] = serialize(getConf()->roles);
}

function inRole($role){
    return isset(getConf()->roles[$role]);
}