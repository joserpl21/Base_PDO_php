<!DOCTYPE html>
<?php
require_once './conectar.php';
$ver = FALSE;
session_start();
if (isset($_SESSION['conexion'])) {
    $host = $_SESSION['conexion']['host'];
    $user = $_SESSION['conexion']['user'];
    $pass = $_SESSION['conexion']['pass'];
}

if (isset($_POST['conecta'])) {

    $host = $_POST['host'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $_SESSION['conexion']['host'] = $host;
    $_SESSION['conexion']['user'] = $user;
    $_SESSION['conexion']['pass'] = $pass;
}
if (isset($_SESSION['conexion'])) {
    $flag = conectar($host, $user, $pass);
    if (!is_null($flag)) {
        $sentencia = ("SHOW DATABASES");
        $bases = consultar($flag, $sentencia);
        $ver = true;
    } else {
        $cor = TRUE;
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="Css.css" type="text/css">
        <style>

            .error{
                background-color: greenyellow;
                height: 100px;
                font-size: 1em;
            }

        </style>
    </head>
    <body>

        <?php if ($cor) { ?>
            <div class="error">
                <h1><?php echo show_msj(); ?></h1>
            </div>
        <?php } ?>
        <form method="POST" action="index.php">
            <fieldset>
                <legend>Datos de conexión</legend>
                <label>Host</label> <input type="text" name="host" <?php
                if ($ver) {
                    echo " value='$host'";
                }
                ?>>
                <label>Usuario</label> <input type="text" name="user" <?php
                if ($ver) {
                    echo " value='$user'";
                }
                ?>>
                <a href="gestionarTabla.php"></a>
                <label>Password</label> <input type="text" name="pass" <?php
                if ($ver) {
                    echo " value='$pass'";
                }
                ?>>
                <input type="submit" name="conecta" value="conectar">
            </fieldset>
        </form>

        <?php if ($ver) { ?>
            <div id="tablas">
                <form method="POST" action="tablas.php">
                    <fieldset>
                        <legend>Gestion de las Bases de Datos del host <label id="host"><?php echo $host ?></label></legend>
                            <?php
                            foreach ($bases as $base) {
                                echo "<input type='radio' value=$base name='base'> $base<br />";
                            }
                            ?>
                        <input type="submit" name="gestion" value="Gestionar">
                    </fieldset>
                </form>
            </div>
        <?php } ?>
    </body>
</html>
