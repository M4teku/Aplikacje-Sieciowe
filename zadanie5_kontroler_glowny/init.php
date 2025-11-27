<?php
require_once 'core/Config.class.php';
$conf = new core\Config();
require_once 'config.php';

function &getConf(){ global $conf; return $conf; }

require_once 'core/Messages.class.php';
$msgs = new core\Messages();
function &getMessages(){ global $msgs; return $msgs; }

$smarty = null;	
function &getSmarty(){
	global $smarty;
	if (!isset($smarty)){
		// SMARTY W LIB/ (poza app)
		include_once getConf()->root_path.'/lib/Smarty.class.php';
		$smarty = new Smarty();	
		
		// PRZYPISZ KONFIGURACJĘ
		$smarty->assign('conf',getConf());
		$smarty->assign('msgs',getMessages());
		
		// ŚCIEŻKI
		$smarty->setTemplateDir(getConf()->root_path.'/app/views');
		$smarty->setCompileDir(getConf()->root_path.'/templates_c/');
		$smarty->setCacheDir(getConf()->root_path.'/cache/');
		$smarty->setConfigDir(getConf()->root_path.'/configs/');
	}
	return $smarty;
}

require_once 'core/ClassLoader.class.php';
$cloader = new core\ClassLoader();
function &getLoader() { return $cloader; }

require_once 'core/functions.php';

$action = getFromRequest('action');