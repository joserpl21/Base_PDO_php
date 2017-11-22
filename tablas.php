<!doctype html>
<?php
require_once './conectar.php';
session_start();
if (isset($_POST['gestion'])) {
    $base = $_POST['base'];
    $_SESSION['conexion']['base'] = $base;
    $conexion = conectarBase($_SESSION['conexion']['host'], $_SESSION['conexion']['base'], $_SESSION['conexion']['user'], $_SESSION['conexion']['pass']);
}
if (isset($_SESSION['conexion'])) {
    $conexion = conectarBase($_SESSION['conexion']['host'], $_SESSION['conexion']['base'], $_SESSION['conexion']['user'], $_SESSION['conexion']['pass']);
    $base = $_SESSION['conexion']['base'];
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" href="Css.css">
    </head>
    <body>
        <form action="gestionarTabla.php" method="post">
            <fieldset>
                <legend>Gestion de la base de Datos <label id="host"><?php echo $base ?></label></legend>
                <?php
                $sentencia = "show TABLES";
                $tablas = consultarBase($conexion, $sentencia);
                foreach ($tablas as $tabla) {
                    echo "<input type='submit' name='tabla' value=$tabla>";
                }
                ?>
            </fieldset>
        </form>
        <div id="tablas">
            <form action="index.php" method="post">
                <fieldset>
                    <legend>Listado de bases de datos</legend>
                    <input type="submit" value="Volver" name="volver">
                </fieldset>
            </form>
        </div>
    </body>
</html>