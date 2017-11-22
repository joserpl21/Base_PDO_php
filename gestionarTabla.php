<!doctype html>
<?php
require_once './conectar.php';
session_start();
if (isset($_POST['tabla'])) {
    $tabla = $_POST['tabla'];
    $_SESSION['conexion']['tabla'] = $tabla;
    $conexion = conectarBase($_SESSION['conexion']['host'], $_SESSION['conexion']['base'], $_SESSION['conexion']['user'], $_SESSION['conexion']['pass']);
    $sentencia = "select * from $tabla";
    $va = consultarTabla($conexion, $sentencia);
}
if (isset($_SESSION['conexion'])) {
    $tabla = $_SESSION['conexion']['tabla'];
    $conexion = conectarBase($_SESSION['conexion']['host'], $_SESSION['conexion']['base'], $_SESSION['conexion']['user'], $_SESSION['conexion']['pass']);
    $sentencia = "select * from $tabla";
    $va = consultarTabla($conexion, $sentencia);
}
?>
<html lang="es">
    <head>
        <!--<meta charset="UTF-8">-->
        <meta charset="ISO-8859-1">
        <title>Document</title>
        <style>
            fieldset{
                border: 0.25em solid;
                align : center;
                position: absolute;
                left: 20%;
                top: 30%;
                margin-left: -115px;
                margin-top: -80px;
                padding:10px;
                background-color: #eee;
            }

            table,tr,th,td{
                border: 1px solid black;
                border-collapse: collapse;
            }

            legend{
                font-size: 2em;
                color: green;
                font-weight: bold;
            }


            body{
                background-color: activecaption;
            }

            label{
                color: red;
            }
        </style>
    </head>
    <body>

        <fieldset>
            <legend>Gestion tabla <label><?php echo "$tabla"; ?></label></legend>
            <table>
                <?php
                echo "<tr>";
                foreach ($va as $index => $fila) {
                    foreach ($fila as $campo => $valor) {
                        if ($index == 0) {
                            echo "<th>$campo</th>";
                        }
                    }
                }
                echo "</tr>";
                foreach ($va as $index => $fila) {
                    echo "<tr><form action='insetar.php' method='post'>";
                    foreach ($fila as $campo => $valor) {
                        echo "<td>$valor</td>";
                        echo "<input type='hidden' value=$campo name='campo'><input type='hidden' value='$valor' name='valor'>";
                    }
                    echo "<td><input type='submit' value='Borrar' name='opcion'></td><td><input type='submit' value='Modificar' name='opcion'></td>";
                    echo "</tr></form>";
                }
                ?>
            </table>

            <br />
            <form action="insetar.php" method="POST">
                <input type="submit" value="Agregar" name="opcion">
                <input type="submit" value="Volver" name="opcion">
            </form>
        </fieldset>
    </body>
</html>