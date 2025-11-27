<?php
require_once dirname(__FILE__).'/../config.php';
require_once _ROOT_PATH.'/config_smarty.php';
require_once 'Messages.class.php';
require_once 'CreditForm.class.php';
require_once 'CreditResult.class.php';

class CreditCtrl {
    private $msgs;
    private $form;
    private $result;

    public function __construct(){
        $this->msgs = new Messages();
        $this->form = new CreditForm();
        $this->result = new CreditResult();
    }

    public function getParams(){
        $this->form->amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : null;
        $this->form->years = isset($_REQUEST['years']) ? $_REQUEST['years'] : null;
        $this->form->interest = isset($_REQUEST['interest']) ? $_REQUEST['interest'] : null;
    }

    public function validate() {
        global $role;

        if (! (isset($this->form->amount) && isset($this->form->years) && isset($this->form->interest))) {
            return false;
        }

        if ($this->form->amount == "") $this->msgs->addError('Nie podano kwoty kredytu');
        if ($this->form->years == "") $this->msgs->addError('Nie podano liczby lat');
        if ($this->form->interest == "") $this->msgs->addError('Nie podano oprocentowania');

        if (! $this->msgs->isError()) {
            if (! is_numeric($this->form->amount)) {
                $this->msgs->addError('Kwota kredytu nie jest liczbą');
            }
            
            if (! is_numeric($this->form->years)) {
                $this->msgs->addError('Liczba lat nie jest liczbą');
            }
            
            if (! is_numeric($this->form->interest)) {
                $this->msgs->addError('Oprocentowanie nie jest liczbą');
            }

            // WALIDACJA KONTEXTOWA - TYLKO DLA KREDYTOWEGO (liczby nie mogą być ujemne)
            if (is_numeric($this->form->amount) && $this->form->amount <= 0) {
                $this->msgs->addError('Kwota kredytu musi być większa od zera');
            }
            
            if (is_numeric($this->form->years) && $this->form->years <= 0) {
                $this->msgs->addError('Liczba lat musi być większa od zera');
            }
            
            if (is_numeric($this->form->interest) && $this->form->interest < 0) {
                $this->msgs->addError('Oprocentowanie nie może być ujemne');
            }
        }

        return ! $this->msgs->isError();
    }

    public function process(){
        global $role;

        $this->getParams();
        
        if ($this->validate()) {
            $this->form->amount = floatval($this->form->amount);
            $this->form->years = floatval($this->form->years);
            $this->form->interest = floatval($this->form->interest);
            $this->msgs->addInfo('Parametry poprawne.');

            // PODZIAŁ FUNKCJONALNOŚCI NA ROLE (Zadanie 2)
            if ($role != 'admin') {
                // Ograniczenia dla zwykłego użytkownika
                if ($this->form->amount > 100000) {
                    $this->msgs->addError('Tylko administrator może obliczać kredyty powyżej 100 000 zł');
                }
                if ($this->form->interest > 10) {
                    $this->msgs->addError('Tylko administrator może obliczać kredyty z oprocentowaniem powyżej 10%');
                }
            }

            if (! $this->msgs->isError()) {
                // Wykonanie obliczeń
                $months = $this->form->years * 12;
                $monthly_rate = ($this->form->interest / 100) / 12;

                if ($monthly_rate == 0) {
                    $this->result->result = $this->form->amount / $months;
                } else {
                    $this->result->result = $this->form->amount * ($monthly_rate / (1 - pow(1 + $monthly_rate, -$months)));
                }

                $this->msgs->addInfo('Wykonano obliczenia.');
            }
        }
        
        $this->generateView();
    }

    public function generateView(){
        global $role;

        $smarty = getSmarty();
        $smarty->assign('page_title', 'Kalkulator kredytowy');
        $smarty->assign('page_description', 'Oblicz miesięczną ratę swojego kredytu');
        $smarty->assign('current_page', 'credit');
        $smarty->assign('user', isset($_SESSION['user']) ? $_SESSION['user'] : 'Gość');
        $smarty->assign('role', $role);
        $smarty->assign('msgs', $this->msgs);
        $smarty->assign('form', $this->form);
        $smarty->assign('res', $this->result);
        $smarty->display('credit.tpl');
    }
}
?>