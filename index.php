<?php
session_start();

$moneda = '';
$dinero = '';
$postura = '';
$pot = $_SESSION['pot'] ?? ($_POST['pot'] ?? '');

if (isset($_POST['reiniciar'])) {
    $pot = 100;
    $_SESSION['pot'] = $pot;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dinero = trim((string) ($_POST['dinero'] ?? ''));
    $postura = $_POST['postura'] ?? '';

    if ($pot === '') {
        $pot = 100;
    }

    $potActual = (int) $pot;
    $cantidad = (int) $dinero;

    if ($potActual > 0 && $cantidad > 0 && $cantidad <= $potActual && ($postura === 'CARA' || $postura === 'CRUZ')) {
        $caras = ['CARA', 'CRUZ'];
        $moneda = $caras[random_int(0, 1)];

        if ($moneda === $postura) {
            $pot = $potActual + $cantidad;
        } else {
            $pot = $potActual - $cantidad;
        }
        $_SESSION['pot'] = $pot;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cara o Cruz 2.0</title>
</head>

<body>
    <h1>CARA O CRUZ 2.0</h1>

    <form action="" method="post">
        <fieldset>
            <legend>MONEDA</legend>
            <input type="text" name="resultado" value="<?= $moneda ?>" readonly>
        </fieldset>

        <fieldset>
            <legend>POSTURA</legend>
            <input type="submit" name="apostar" value="Apostar">
            Dinero:<input type="text" name="dinero" value="<?= htmlspecialchars((string) $dinero) ?>">
            Cara: <input type="radio" name="postura" value="CARA" <?= $postura === 'CARA' ? 'checked' : '' ?>>
            Cruz <input type="radio" name="postura" value="CRUZ" <?= $postura === 'CRUZ' ? 'checked' : '' ?>>
        </fieldset>

        <fieldset>
            <legend>POT</legend>
            <br>
            <?= $pot ?>
            <input type="hidden" name="pot" value="<?= $pot ?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="reiniciar" value="Reiniciar">
            <br><br>
        </fieldset>
    </form>
</body>

</html>
