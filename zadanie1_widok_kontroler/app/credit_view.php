<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kalkulator kredytowy</title>
</head>
<body>

<h1>Kalkulator kredytowy</h1>

   <form action="<?php echo _APP_URL; ?>/app/credit_calc.php" method="get">

    <label>Kwota kredytu: </label>
    <input type="text" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>"><br><br>

    <label>Liczba lat: </label>
    <input type="text" name="years" value="<?php echo isset($years) ? $years : ''; ?>"><br><br>

    <label>Oprocentowanie (% rocznie): </label>
    <input type="text" name="interest" value="<?php echo isset($interest) ? $interest : ''; ?>"><br><br>

    <input type="submit" value="Oblicz ratę">
</form>

<?php
if (isset($messages) && count($messages) > 0) {
    echo '<ol style="color:red;">';
    foreach ($messages as $msg) {
        echo '<li>'.$msg.'</li>';
    }
    echo '</ol>';
}
?>

<?php if (isset($result)) { ?>
    <h2>Miesięczna rata: <?php echo round($result, 2); ?> zł</h2>
<?php } ?>

</body>
</html>
