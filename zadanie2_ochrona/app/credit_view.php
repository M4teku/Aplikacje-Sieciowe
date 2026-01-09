<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Kalkulator kredytowy</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
    <a href="<?php print(_APP_ROOT); ?>/app/calc.php" class="pure-button">Kalkulator prosty</a>
    <a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
    <span style="float:right;">
        Zalogowany jako: <strong><?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : ''; ?></strong>
        (<?php echo isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : ''; ?>)
    </span>
</div>

<div style="width:90%; margin: 2em auto;">

<form action="<?php print(_APP_ROOT); ?>/app/credit_calc.php" method="post" class="pure-form pure-form-stacked">
    <legend>Kalkulator kredytowy (<?php echo isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : ''; ?>)</legend>
    <fieldset>
        <label for="id_amount">Kwota kredytu: </label>
        <input id="id_amount" type="text" name="amount" value="<?php out($amount) ?>" />
        <label for="id_years">Liczba lat: </label>
        <input id="id_years" type="text" name="years" value="<?php out($years) ?>" />
        <label for="id_interest">Oprocentowanie (% rocznie): </label>
        <input id="id_interest" type="text" name="interest" value="<?php out($interest) ?>" />
    </fieldset>  
    <input type="submit" value="Oblicz ratę" class="pure-button pure-button-primary" />
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
<?php echo 'Miesięczna rata: '.round($result, 2).' zł'; ?>
</div>
<?php } ?>

<!-- INFORMACJE DLA RÓŻNYCH RÓL W KALKULATORZE KREDYTOWYM -->
<?php if (isset($_SESSION['role'])): ?>
<div style="margin-top: 2em; padding: 1em; border: 1px solid #ccc; border-radius: 0.5em; background-color: #f5f5f5; width:30em;">
    <strong>Informacje dla roli: <?php echo htmlspecialchars($_SESSION['role']); ?></strong>
    
    <?php if ($_SESSION['role'] == 'user'): ?>
        <ul>
            <li>Maksymalna kwota kredytu: <strong>100 000 zł</strong></li>
            <li>Maksymalny okres kredytowania: <strong>10 lat</strong></li>
            <li>Maksymalne oprocentowanie: <strong>15%</strong></li>
            <li>Wszystkie wartości muszą być dodatnie</li>
        </ul>
    <?php elseif ($_SESSION['role'] == 'admin'): ?>
        <ul>
            <li>Maksymalna kwota kredytu: <strong>1 000 000 zł</strong></li>
            <li>Maksymalny okres kredytowania: <strong>30 lat</strong></li>
            <li>Maksymalne oprocentowanie: <strong>30%</strong></li>
            <li>Masz większe limity niż użytkownik</li>
        </ul>
    <?php endif; ?>
</div>
<?php endif; ?>

</div>

</body>
</html>