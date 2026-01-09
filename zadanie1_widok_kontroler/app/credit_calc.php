<?php
require_once dirname(__FILE__) . '/../config.php';

// Pobranie parametrów
$amount = $_REQUEST['amount'] ?? null;
$years = $_REQUEST['years'] ?? null;
$interest = $_REQUEST['interest'] ?? null;

// Tablica komunikatów
$messages = [];

// Wykonuje się tylko jeśli formularz został wysłany
if (isset($_REQUEST['amount']) && isset($_REQUEST['years']) && isset($_REQUEST['interest'])) {

    // Walidacja podstawowa (czy podano wartości)
    if ($amount === "") $messages[] = 'Nie podano kwoty kredytu.';
    if ($years === "") $messages[] = 'Nie podano liczby lat.';
    if ($interest === "") $messages[] = 'Nie podano oprocentowania.';

    if (empty($messages)) {
        // Walidacja typów
        if (!is_numeric($amount)) $messages[] = 'Kwota musi być liczbą.';
        if (!is_numeric($years)) $messages[] = 'Liczba lat musi być liczbą.';
        if (!is_numeric($interest)) $messages[] = 'Oprocentowanie musi być liczbą.';
        
        // Walidacja kontekstowa - tylko jeśli wartości są liczbami
        if (empty($messages)) {
            $amount_num = floatval($amount);
            $years_num = floatval($years);
            $interest_num = floatval($interest);
            
            // Sprawdzenie wartości minimalnych/maksymalnych
            if ($amount_num <= 0) $messages[] = 'Kwota kredytu musi być większa od 0.';
            if ($years_num <= 0) $messages[] = 'Liczba lat musi być większa od 0.';
            if ($interest_num < 0) $messages[] = 'Oprocentowanie nie może być ujemne.';
            
          
            if ($years_num > 50) $messages[] = 'Maksymalny okres kredytowania to 50 lat.';
            if ($interest_num > 50) $messages[] = 'Oprocentowanie nie może przekraczać 50%.';
            if ($amount_num > 10000000) $messages[] = 'Maksymalna kwota kredytu to 10 000 000 zł.';
        }
    }

    // Obliczenia
    if (empty($messages)) {
        $amount = floatval($amount);
        $years = floatval($years);
        $interest = floatval($interest);

        $months = $years * 12;
        $monthly_rate = ($interest / 100) / 12;

        if ($monthly_rate == 0) {
            $result = $amount / $months;
        } else {
            $result = $amount * ($monthly_rate / (1 - pow(1 + $monthly_rate, -$months)));
        }
    }
}

// Wywołanie widoku
include _ROOT_PATH . '/app/credit_view.php';
?>