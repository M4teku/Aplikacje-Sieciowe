<?php
namespace app\controllers;

use app\forms\LoginForm;
use app\transfer\User;

class LoginCtrl {
    private $form;
    private $msgs;

    public function __construct(){
        $this->form = new LoginForm();
        $this->msgs = new \core\Messages();
    }

    public function getParams(){
        $this->form->login = \getFromRequest('login');
        $this->form->pass = \getFromRequest('pass');
    }

    public function validate() {
        if (!(isset($this->form->login) && isset($this->form->pass))) {
            return false;
        }

        if ($this->form->login == "") {
            $this->msgs->addError('Nie podano loginu');
        }
        if ($this->form->pass == "") {
            $this->msgs->addError('Nie podano hasła');
        }

        if (count($this->msgs->getErrors()) > 0) return false;

        if ($this->form->login == "admin" && $this->form->pass == "admin") {
            $user = new User($this->form->login, 'admin');
            $_SESSION['user'] = serialize($user);
            \addRole('admin');
            return true;
        }
        if ($this->form->login == "user" && $this->form->pass == "user") {
            $user = new User($this->form->login, 'user');
            $_SESSION['user'] = serialize($user);
            \addRole('user');
            return true;
        }
        
        $this->msgs->addError('Niepoprawny login lub hasło');
        return false; 
    }

    public function action_login(){
        $this->getParams();
        
        if ($this->validate()) {
            \redirectTo('simpleView');
        } else {
            $this->generateView();
        }
    }

    public function action_logout(){
        session_destroy();
        $this->msgs->addInfo('Poprawnie wylogowano z systemu');
        $this->generateView();
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