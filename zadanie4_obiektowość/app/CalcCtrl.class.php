<?php
require_once dirname(__FILE__).'/../config.php';
require_once _ROOT_PATH.'/config_smarty.php';
require_once 'Messages.class.php';
require_once 'CalcForm.class.php';
require_once 'CalcResult.class.php';

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
        $this->form->x = isset($_REQUEST['x']) ? $_REQUEST['x'] : null;
        $this->form->y = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
        $this->form->op = isset($_REQUEST['op']) ? $_REQUEST['op'] : null;
    }

    public function validate() {
        global $role;

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
            // BRAK WALIDACJI KONTEXTOWEJ - liczby MOGĄ być ujemne w kalkulatorze prostym
        }

        return ! $this->msgs->isError();
    }

    public function process(){
        global $role;

        $this->getParams();
        
        if ($this->validate()) {
            $this->form->x = floatval($this->form->x);
            $this->form->y = floatval($this->form->y);
            $this->msgs->addInfo('Parametry poprawne.');

            // PODZIAŁ FUNKCJONALNOŚCI NA ROLE (Zadanie 2)
            switch ($this->form->op) {
                case 'minus':
                    if ($role == 'admin'){
                        $this->result->result = $this->form->x - $this->form->y;
                        $this->result->op_name = '-';
                    } else {
                        $this->msgs->addError('Tylko administrator może odejmować!');
                    }
                    break;
                case 'times':
                    $this->result->result = $this->form->x * $this->form->y;
                    $this->result->op_name = '×';
                    break;
                case 'div':
                    if ($role == 'admin'){
                        if ($this->form->y == 0) {
                            $this->msgs->addError('Nie można dzielić przez zero!');
                        } else {
                            $this->result->result = $this->form->x / $this->form->y;
                            $this->result->op_name = '÷';
                        }
                    } else {
                        $this->msgs->addError('Tylko administrator może dzielić!');
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
        global $role;

        $smarty = getSmarty();
        $smarty->assign('page_title', 'Kalkulator prosty');
        $smarty->assign('current_page', 'simple');
        $smarty->assign('user', isset($_SESSION['user']) ? $_SESSION['user'] : 'Gość');
        $smarty->assign('role', $role);
        $smarty->assign('msgs', $this->msgs);
        $smarty->assign('form', $this->form);
        $smarty->assign('res', $this->result);
        $smarty->display('calc.tpl');
    }
}
?>