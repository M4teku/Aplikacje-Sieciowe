<?php
require_once dirname(__FILE__).'/../../config.php';
require_once _ROOT_PATH.'/config_smarty.php';

//inicjacja sesji
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//pobranie parametrów
function getParamsLogin(&$form){
    $form['login'] = isset($_REQUEST['login']) ? $_REQUEST['login'] : null;
    $form['pass'] = isset($_REQUEST['pass']) ? $_REQUEST['pass'] : null;
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validateLogin(&$form,&$messages){
    // sprawdzenie, czy parametry zostały przekazane
    if (!(isset($form['login']) && isset($form['pass']))) {
        return false;
    }

    // sprawdzenie, czy potrzebne wartości zostały przekazane
    if ($form['login'] == "") {
        $messages[] = 'Nie podano loginu';
    }
    if ($form['pass'] == "") {
        $messages[] = 'Nie podano hasła';
    }

    //nie ma sensu walidować dalej, gdy brak parametrów
    if (count($messages) > 0) return false;

    // sprawdzenie, czy dane logowania są poprawne
    if ($form['login'] == "admin" && $form['pass'] == "admin") {
        $_SESSION['role'] = 'admin';
        $_SESSION['user'] = $form['login'];
        return true;
    }
    if ($form['login'] == "user" && $form['pass'] == "user") {
        $_SESSION['role'] = 'user';
        $_SESSION['user'] = $form['login'];
        return true;
    }
    
    $messages[] = 'Niepoprawny login lub hasło';
    return false; 
}

//inicjacja potrzebnych zmiennych
$form = array();
$messages = array();

getParamsLogin($form);

if (!validateLogin($form,$messages)) {
    $smarty = getSmarty();
    $smarty->assign('page_title', 'Logowanie');
    $smarty->assign('form', $form);
    $smarty->assign('messages', $messages);
    $smarty->assign('current_page', 'login');
    $smarty->assign('user', 'Gość');
    $smarty->assign('show_logout', false); // DODAJ TE LINIĘ - ukrywa przycisk wyloguj
    $smarty->display('login.tpl');
} else { 
    //przekierowanie na stronę główną - POPRAWIONY LINK
    header("Location: "._APP_URL."/app/calc.php");
    exit();
}
?>