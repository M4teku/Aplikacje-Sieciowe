<?php
require_once dirname(__FILE__).'/../config.php';
require_once _ROOT_PATH.'/config_smarty.php';

//ochrona kontrolera
include _ROOT_PATH.'/app/security/check.php';

//pobranie parametrów
function getParams(&$x,&$y,&$operation){
    $x = isset($_REQUEST['x']) ? $_REQUEST['x'] : null;
    $y = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
    $operation = isset($_REQUEST['op']) ? $_REQUEST['op'] : null;    
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$x,&$y,&$operation,&$messages){
    // sprawdzenie, czy parametry zostały przekazane
    if (!(isset($x) && isset($y) && isset($operation))) {
        return false;
    }

    // sprawdzenie, czy potrzebne wartości zostały przekazane
    if ($x == "") {
        $messages[] = 'Nie podano liczby 1';
    }
    if ($y == "") {
        $messages[] = 'Nie podano liczby 2';
    }

    if (count($messages) != 0) return false;
    
    // sprawdzenie, czy $x i $y są liczbami całkowitymi
    if (!is_numeric($x)) {
        $messages[] = 'Pierwsza wartość nie jest liczbą całkowitą';
    }
    
    if (!is_numeric($y)) {
        $messages[] = 'Druga wartość nie jest liczbą całkowitą';
    }    

    // WALIDACJA KONTEKSTOWA - liczby nie mogą być ujemne
    if (is_numeric($x) && $x < 0) {
        $messages[] = 'Liczba 1 nie może być ujemna';
    }
    
    if (is_numeric($y) && $y < 0) {
        $messages[] = 'Liczba 2 nie może być ujemna';
    }

    if (count($messages) != 0) return false;
    else return true;
}

function process(&$x,&$y,&$operation,&$messages,&$result){
    global $role;
    
    //konwersja parametrów na int
    $x = intval($x);
    $y = intval($y);
    
    //wykonanie operacji
    switch ($operation) {
        case 'minus':
            if ($role == 'admin'){
                $result = $x - $y;
            } else {
                $messages[] = 'Tylko administrator może odejmować!';
            }
            break;
        case 'times':
            $result = $x * $y;
            break;
        case 'div':
            if ($role == 'admin'){
                if ($y == 0) {
                    $messages[] = 'Nie można dzielić przez zero!';
                } else {
                    $result = $x / $y;
                }
            } else {
                $messages[] = 'Tylko administrator może dzielić!';
            }
            break;
        default:
            $result = $x + $y;
            break;
    }
}

//definicja zmiennych kontrolera
$x = null;
$y = null;
$operation = null;
$result = null;
$messages = array();

//pobiera parametry i wykonuje zadanie jeśli wszystko w porządku
getParams($x,$y,$operation);
if (validate($x,$y,$operation,$messages)) { // gdy brak błędów
    process($x,$y,$operation,$messages,$result);
}

// SMARTY
$smarty = getSmarty();
$smarty->assign('page_title', 'Kalkulator prosty');
$smarty->assign('x', $x);
$smarty->assign('y', $y);
$smarty->assign('operation', $operation);
$smarty->assign('result', $result);
$smarty->assign('messages', $messages);
$smarty->assign('role', $role);
$smarty->assign('current_page', 'simple');
$smarty->assign('user', isset($_SESSION['user']) ? $_SESSION['user'] : 'Gość');
$smarty->display('calc.tpl');  
?>