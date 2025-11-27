<?php
namespace app\controllers;

use app\forms\CreditForm;
use app\transfer\CreditResult;
use core\Messages;

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
        $this->form->amount = getFromRequest('amount');
        $this->form->years = getFromRequest('years');
        $this->form->interest = getFromRequest('interest');
    }

    public function validate() {
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

            // WALIDACJA KONTEXTOWA
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
        $this->getParams();
        
        if ($this->validate()) {
            $this->form->amount = floatval($this->form->amount);
            $this->form->years = floatval($this->form->years);
            $this->form->interest = floatval($this->form->interest);
            $this->msgs->addInfo('Parametry poprawne.');

            // PODZIAŁ RÓL - TYLKO W KREDYTOWYM
            $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
            if ($role != 'admin') {
                if ($this->form->amount > 100000) {
                    $this->msgs->addError('Tylko administrator może obliczać kredyty powyżej 100 000 zł');
                }
                if ($this->form->interest > 20) {
                    $this->msgs->addError('Tylko administrator może obliczać kredyty z oprocentowaniem powyżej 20%');
                }
            }

            if (! $this->msgs->isError()) {
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
        $smarty = getSmarty();
        $smarty->assign('page_title', 'Kalkulator kredytowy');
        $smarty->assign('page_description', 'Oblicz miesięczną ratę swojego kredytu');
        $smarty->assign('current_page', 'credit');
        $smarty->assign('user', isset($_SESSION['user']) ? $_SESSION['user'] : 'Gość');
        $smarty->assign('role', isset($_SESSION['role']) ? $_SESSION['role'] : '');
        $smarty->assign('msgs', $this->msgs);
        $smarty->assign('form', $this->form);
        $smarty->assign('res', $this->result);
        $smarty->display('credit.tpl');
    }
}