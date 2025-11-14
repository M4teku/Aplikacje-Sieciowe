<?php
require_once dirname(__FILE__) . '/config.php';

//przekierowanie przeglądarki klienta (redirect)
header("Location: "._APP_URL."/app/calc.php");
exit();
?> 