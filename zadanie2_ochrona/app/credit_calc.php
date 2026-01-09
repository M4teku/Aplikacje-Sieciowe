<?php
require_once dirname(__FILE__) . '/../config.php';

// KONTROLER strony kalkulatora kredytowego
include _ROOT_PATH.'/app/security/check.php'; 

//pobranie parametrów
function getParams(&$amount,&$years,&$interest){
    $amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
    $years = isset($_REQUEST['years']) ? $_REQUEST['years'] : null;
    $interest = isset($_REQUEST['interest']) ? $_REQUEST['interest'] : null;
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$amount,&$years,&$interest,&$messages){
    global $role;
    
    // sprawdzenie, czy parametry zostały przekazane
    if (!(isset($amount) && isset($years) && isset($interest))) {
        return false;
    }

    // sprawdzenie, czy potrzebne wartości zostały przekazane
    if ($amount == "") {
        $messages[] = 'Nie podano kwoty kredytu';
    }
    if ($years == "") {
        $messages[] = 'Nie podano liczby lat';
    }
    if ($interest == "") {
        $messages[] = 'Nie podano oprocentowania';
    }

    //nie walidować dalej gdy brak parametrów
    if (count($messages) != 0) return false;
    
    // sprawdzenie, czy dane są liczbami
    if (!is_numeric($amount)) {
        $messages[] = 'Kwota kredytu nie jest liczbą';
    }
    
    if (!is_numeric($years)) {
        $messages[] = 'Liczba lat nie jest liczbą';
    }
    
    if (!is_numeric($interest)) {
        $messages[] = 'Oprocentowanie nie jest liczbą';
    }

    if (count($messages) != 0) return false;
    
    // walidacja kontekstowa - różna do ról
    $amount_num = floatval($amount);
    $years_num = floatval($years);
    $interest_num = floatval($interest);
    
    // różne zakresy dla admina i usera
    if ($role == 'user') {
        // Użytkownik: mniejsze limity
        if ($amount_num <= 0) {
            $messages[] = 'Kwota kredytu musi być większa od 0 (użytkownik)';
        }
        if ($amount_num > 100000) {
            $messages[] = 'Maksymalna kwota kredytu to 100 000 zł (użytkownik)';
        }
        
        if ($years_num <= 0) {
            $messages[] = 'Liczba lat musi być większa od 0 (użytkownik)';
        }
        if ($years_num > 10) {
            $messages[] = 'Maksymalny okres kredytowania to 10 lat (użytkownik)';
        }
        
        if ($interest_num < 0) {
            $messages[] = 'Oprocentowanie nie może być ujemne (użytkownik)';
        }
        if ($interest_num > 15) {
            $messages[] = 'Maksymalne oprocentowanie to 15% (użytkownik)';
        }
    } elseif ($role == 'admin') {
        // Administrator: większe limity
        if ($amount_num <= 0) {
            $messages[] = 'Kwota kredytu musi być większa od 0 (admin)';
        }
        if ($amount_num > 1000000) {
            $messages[] = 'Maksymalna kwota kredytu to 1 000 000 zł (admin)';
        }
        
        if ($years_num <= 0) {
            $messages[] = 'Liczba lat musi być większa od 0 (admin)';
        }
        if ($years_num > 30) {
            $messages[] = 'Maksymalny okres kredytowania to 30 lat (admin)';
        }
        
        if ($interest_num < 0) {
            $messages[] = 'Oprocentowanie nie może być ujemne (admin)';
        }
        if ($interest_num > 30) {
            $messages[] = 'Maksymalne oprocentowanie to 30% (admin)';
        }
    }

    if (count($messages) != 0) return false;
    else return true;
}

function process(&$amount,&$years,&$interest,&$messages,&$result){
    //konwersja parametrów na float
    $amount = floatval($amount);
    $years = floatval($years);
    $interest = floatval($interest);

    //wykonanie obliczeń
    $months = $years * 12;
    $monthly_rate = ($interest / 100) / 12;

    if ($monthly_rate == 0) {
        $result = $amount / $months;
    } else {
        $result = $amount * ($monthly_rate / (1 - pow(1 + $monthly_rate, -$months)));
    }
}

//definicja zmiennych kontrolera
$amount = null;
$years = null;
$interest = null;
$result = null;
$messages = array();

//pobiera parametry i wykonuje zadanie jeśli wszystko w porządku
getParams($amount,$years,$interest);
if (validate($amount,$years,$interest,$messages)) { // gdy brak błędów
    process($amount,$years,$interest,$messages,$result);
}

include 'credit_view.php';
?>