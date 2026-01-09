<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Kalkulator</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
    <a href="<?php print(_APP_ROOT); ?>/app/credit_calc.php" class="pure-button">Kalkulator kredytowy</a>
    <a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
    <span style="float:right;">
        Zalogowany jako: <strong><?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : ''; ?></strong>
        (<?php echo isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : ''; ?>)
    </span>
</div>

<div style="width:90%; margin: 2em auto;">

<form action="<?php print(_APP_ROOT); ?>/app/calc.php" method="post" class="pure-form pure-form-stacked">
    <legend>Kalkulator (<?php echo isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : ''; ?>)</legend>
    <fieldset>
        <label for="id_x">Liczba 1: </label>
        <input id="id_x" type="text" name="x" value="<?php out($x) ?>" />
        <label for="id_op">Operacja: </label>
        <select name="op" id="id_op">    
            <option value="plus" <?php if(isset($operation) && $operation == 'plus') echo 'selected'; ?>>+</option>
            
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <option value="minus" <?php if(isset($operation) && $operation == 'minus') echo 'selected'; ?>>-</option>
            <?php endif; ?>
            
            <option value="times" <?php if(isset($operation) && $operation == 'times') echo 'selected'; ?>>*</option>
            
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <option value="div" <?php if(isset($operation) && $operation == 'div') echo 'selected'; ?>>/</option>
            <?php endif; ?>
        </select>
        <label for="id_y">Liczba 2: </label>
        <input id="id_y" type="text" name="y" value="<?php out($y) ?>" />
    </fieldset> 
    <input type="submit" value="Oblicz" class="pure-button pure-button-primary" />
</form>    

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
    if (count($messages) > 0) {
        echo '<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f88; width:25em;">';
        foreach ($messages as $key => $msg) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ol>';
    }
}
?>

<?php if (isset($result)){ ?>
<div style="margin-top: 1em; padding: 1em; border-radius: 0.5em; background-color: #ff0; width:25em;">
<?php echo 'Wynik: '.$result; ?>
</div>
<?php } ?>

<!-- INFORMACJE DLA RÓŻNYCH RÓL - BEZ LICZB UJEMNYCH -->
<?php if (isset($_SESSION['role'])): ?>
<div style="margin-top: 2em; padding: 1em; border: 1px solid #ccc; border-radius: 0.5em; background-color: #f5f5f5; width:30em;">
    <strong>Informacje dla roli: <?php echo htmlspecialchars($_SESSION['role']); ?></strong>
    
    <?php if ($_SESSION['role'] == 'user'): ?>
        <ul>
            <li>Możesz używać tylko <strong>liczb dodatnich</strong></li>
            <li>Zakres liczb: od <strong>1 do 100</strong></li>
            <li>Dostępne operacje: <strong>dodawanie (+)</strong> i <strong>mnożenie (*)</strong></li>
            <li>Odejmowanie (-) i dzielenie (/) są <strong>zablokowane</strong></li>
        </ul>
    <?php elseif ($_SESSION['role'] == 'admin'): ?>
        <ul>
            <li>Możesz używać tylko <strong>liczb dodatnich</strong></li>
            <li>Zakres liczb: od <strong>1 do 1000</strong></li>
            <li>Wszystkie operacje są dostępne: <strong>+, -, *, /</strong></li>
            <li>Możesz dzielić przez dowolną liczbę (oprócz zera)</li>
        </ul>
    <?php endif; ?>
</div>
<?php endif; ?>

</div>

</body>
</html>