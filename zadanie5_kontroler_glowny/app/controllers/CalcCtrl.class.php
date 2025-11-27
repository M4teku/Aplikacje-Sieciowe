<?php
namespace app\controllers;

use app\forms\CalcForm;
use app\transfer\CalcResult;
use core\Messages;

class CalcCtrl {
    private $msgs;
    private $form;
    private $result;

    public function __construct(){
        $this->msgs = new Messages();
        $this->form = new CalcForm();
        $this->result = new CalcResult();
    }

    public function getParams(){
        $this->form->x = getFromRequest('x');
        $this->form->y = getFromRequest('y');
        $this->form->op = getFromRequest('op');
    }

    public function validate() {
        if (! (isset($this->form->x) && isset($this->form->y) && isset($this->form->op))) {
            return false;
        }

        if ($this->form->x == "") $this->msgs->addError('Nie podano liczby 1');
        if ($this->form->y == "") $this->msgs->addError('Nie podano liczby 2');

        if (! $this->msgs->isError()) {
            if (! is_numeric($this->form->x)) {
                $this->msgs->addError('Liczba 1 nie jest liczbą całkowitą');
            }
            
            if (! is_numeric($this->form->y)) {
                $this->msgs->addError('Liczba 2 nie jest liczbą całkowitą');
            }
        }

        return ! $this->msgs->isError();
    }

    public function process(){
        $this->getParams();
        
        if ($this->validate()) {
            $this->form->x = floatval($this->form->x);
            $this->form->y = floatval($this->form->y);
            $this->msgs->addInfo('Parametry poprawne.');

            switch ($this->form->op) {
                case 'minus':
                    $this->result->result = $this->form->x - $this->form->y;
                    $this->result->op_name = '-';
                    break;
                case 'times':
                    $this->result->result = $this->form->x * $this->form->y;
                    $this->result->op_name = '×';
                    break;
                case 'div':
                    if ($this->form->y == 0) {
                        $this->msgs->addError('Nie można dzielić przez zero!');
                    } else {
                        $this->result->result = $this->form->x / $this->form->y;
                        $this->result->op_name = '÷';
                    }
                    break;
                default:
                    $this->result->result = $this->form->x + $this->form->y;
                    $this->result->op_name = '+';
                    break;
            }

            if (! $this->msgs->isError()) {
                $this->msgs->addInfo('Wykonano obliczenia.');
            }
        }
        
        $this->generateView();
    }

    public function generateView(){
        $smarty = getSmarty();
        $smarty->assign('page_title', 'Kalkulator prosty');
        $smarty->assign('current_page', 'simple');
        $smarty->assign('user', isset($_SESSION['user']) ? $_SESSION['user'] : 'Gość');
        $smarty->assign('role', isset($_SESSION['role']) ? $_SESSION['role'] : '');
        $smarty->assign('msgs', $this->msgs);
        $smarty->assign('form', $this->form);
        $smarty->assign('res', $this->result);
        $smarty->display('calc.tpl');
    }
}