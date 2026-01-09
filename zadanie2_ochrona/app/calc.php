<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora
include _ROOT_PATH.'/app/security/check.php';

//pobranie parametrów
function getParams(&$x,&$y,&$operation){
    $x = isset($_REQUEST['x']) ? $_REQUEST['x'] : null;
    $y = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
    $operation = isset($_REQUEST['op']) ? $_REQUEST['op'] : null;    
}

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$x,&$y,&$operation,&$messages){
    global $role;
    
    // sprawdzenie, czy parametry zostały przekazane
    if ( ! (isset($x) && isset($y) && isset($operation))) {
        return false;
    }

    // sprawdzenie, czy potrzebne wartości zostały przekazane
    if ( $x == "") {
        $messages [] = 'Nie podano liczby 1';
    }
    if ( $y == "") {
        $messages [] = 'Nie podano liczby 2';
    }

    //nie ma sensu walidować dalej gdy brak parametrów
    if (count ( $messages ) != 0) return false;
    
    // sprawdzenie, czy $x i $y są liczbami całkowitymi
    if (! is_numeric( $x )) {
        $messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
    }
    
    if (! is_numeric( $y )) {
        $messages [] = 'Druga wartość nie jest liczbą całkowitą';
    }

    if (count ( $messages ) != 0) return false;
    
    // walidacja kontekstowa - RÓŻNA DLA RÓŻNYCH RÓL
    $x_int = intval($x);
    $y_int = intval($y);
    
    // RÓŻNE ZAKRESY DLA ADMINA I USERA - BEZ LICZB UJEMNYCH
    if ($role == 'user') {
        // Użytkownik: tylko liczby dodatnie, mniejszy zakres
        if ($x_int <= 0) {
            $messages[] = 'Liczba 1 musi być większa od 0 (użytkownik)';
        }
        if ($y_int <= 0) {
            $messages[] = 'Liczba 2 musi być większa od 0 (użytkownik)';
        }
        
        if ($x_int > 100) {
            $messages[] = 'Liczba 1 nie może przekraczać 100 (użytkownik)';
        }
        if ($y_int > 100) {
            $messages[] = 'Liczba 2 nie może przekraczać 100 (użytkownik)';
        }
    } elseif ($role == 'admin') {
        // Administrator: tylko liczby dodatnie, większy zakres
        if ($x_int <= 0) {
            $messages[] = 'Liczba 1 musi być większa od 0 (admin)';
        }
        if ($y_int <= 0) {
            $messages[] = 'Liczba 2 musi być większa od 0 (admin)';
        }
        
        if ($x_int > 1000) {
            $messages[] = 'Liczba 1 nie może przekraczać 1000 (admin)';
        }
        if ($y_int > 1000) {
            $messages[] = 'Liczba 2 nie może przekraczać 1000 (admin)';
        }
    }

    if (count ( $messages ) != 0) return false;
    else return true;
}

function process(&$x,&$y,&$operation,&$messages,&$result){
    global $role;
    
    //konwersja parametrów na int
    $x = intval($x);
    $y = intval($y);
    
    //wykonanie operacji - RÓŻNE DOSTĘPNE OPERACJE DLA RÓŻNYCH RÓL
    switch ($operation) {
        case 'minus' :
            if ($role == 'admin'){
                $result = $x - $y;
            } else {
                $messages [] = 'Tylko administrator może odejmować!';
            }
            break;
        case 'times' :
            $result = $x * $y;
            break;
        case 'div' :
            if ($role == 'admin'){
                // Zabezpieczenie przed dzieleniem przez 0 
                if ($y == 0) {
                    $messages[] = 'Nie można dzielić przez zero!';
                } else {
                    $result = $x / $y;
                }
            } else {
                $messages [] = 'Tylko administrator może dzielić!';
            }
            break;
        default :
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

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($x,$y,$operation);
if ( validate($x,$y,$operation,$messages) ) { // gdy brak błędów
    process($x,$y,$operation,$messages,$result);
}

// Wywołanie widoku z przekazaniem zmiennych
include 'calc_view.php';