<?php
namespace app\security;

class LoginCtrl {
    private $form;
    private $msgs;

    public function __construct(){
        $this->form = array();
        $this->msgs = new \core\Messages();
    }

    public function getParams(){
        $this->form['login'] = \getFromRequest('login');
        $this->form['pass'] = \getFromRequest('pass');
    }

    public function validate() {
        if (!(isset($this->form['login']) && isset($this->form['pass']))) {
            return false;
        }

        if ($this->form['login'] == "") {
            $this->msgs->addError('Nie podano loginu');
        }
        if ($this->form['pass'] == "") {
            $this->msgs->addError('Nie podano hasła');
        }

        if (count($this->msgs->getErrors()) > 0) return false;

        // sprawdzenie danych logowania
        if ($this->form['login'] == "admin" && $this->form['pass'] == "admin") {
            $_SESSION['role'] = 'admin';
            $_SESSION['user'] = $this->form['login'];
            return true;
        }
        if ($this->form['login'] == "user" && $this->form['pass'] == "user") {
            $_SESSION['role'] = 'user';
            $_SESSION['user'] = $this->form['login'];
            return true;
        }
        
        $this->msgs->addError('Niepoprawny login lub hasło');
        return false; 
    }

    public function process(){
        session_start();
        $this->getParams();
        
        if ($this->validate()) {
            // przekierowanie na stronę główną
            header("Location: ".\getConf()->app_url."/ctrl.php?action=simpleView");
            exit();
        } else {
            // pokaż formularz z błędami
            $this->generateView();
        }
    }

  public function generateView(){
    $smarty = \getSmarty();
    $smarty->assign('page_title', 'Logowanie');
    $smarty->assign('form', $this->form);
    $smarty->assign('messages', $this->msgs->getErrors());
    $smarty->assign('current_page', 'login');
    $smarty->assign('user', 'Gość');
    $smarty->assign('show_logout', false);
    $smarty->display('login.tpl');
}
}