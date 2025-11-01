<?php
require_once dirname(__FILE__) . '/../config.php';

// KONTROLER strony kalkulatora kredytowego

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php'; 

//pobranie parametrów
function getParams(&$amount,&$years,&$interest){
    $amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
    $years = isset($_REQUEST['years']) ? $_REQUEST['years'] : null;
    $interest = isset($_REQUEST['interest']) ? $_REQUEST['interest'] : null;
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$amount,&$years,&$interest,&$messages){
    // sprawdzenie, czy parametry zostały przekazane
    if (!(isset($amount) && isset($years) && isset($interest))) {
        // sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
        // teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
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
    else return true;
}

function process(&$amount,&$years,&$interest,&$messages,&$result){
    //konwersja parametrów na float
    $amount = floatval($amount);
    $years = floatval($years);
    $interest = floatval($interest);

    //walidacja wartości
    if ($amount <= 0) {
        $messages[] = 'Kwota kredytu musi być większa od zera';
        return;
    }
    if ($years <= 0) {
        $messages[] = 'Liczba lat musi być większa od zera';
        return;
    }
    if ($interest < 0) {
        $messages[] = 'Oprocentowanie nie może być ujemne';
        return;
    }

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