<?php
require_once 'init.php';

getRouter()->setDefaultRoute('simpleView');
getRouter()->setLoginRoute('login');

getRouter()->addRoute('simpleView', 'CalcCtrl', ['user', 'admin']);
getRouter()->addRoute('calcCompute', 'CalcCtrl', ['user', 'admin']);
getRouter()->addRoute('creditView', 'CreditCtrl', ['user', 'admin']);
getRouter()->addRoute('creditCompute', 'CreditCtrl', ['user', 'admin']);

getRouter()->addRoute('login', 'LoginCtrl');
getRouter()->addRoute('logout', 'LoginCtrl', ['user', 'admin']);

getRouter()->go();