<!doctype html>
<?php
require_once './conectar.php';
session_start();
$conexion = conectarBase($_SESSION['conexion']['host'], $_SESSION['conexion']['base'], $_SESSION['conexion']['user'], $_SESSION['conexion']['pass']);
switch ($_POST['opcion']) {
    case "Volver":
        header('Location:tablas.php');
        break;
    case "Guardar":
        $tabla = $_SESSION['conexion']['tabla'];
        $sentencia = "INSERT INTO $tabla (";
        $frace = $sentencia . " " . $_POST['final'] . " ) values (";
        $cam = $_SESSION['campos'];
        $valores = [];
        foreach ($cam as $a) {
            $sa = $_POST[$a];
            $letras .= " ? " . ",";
            $valores[] = $sa;
        }

        $m = substr($letras, 0, -1);
        $sentencia = $frace . " " . $m . " )";
        $fi = insertar($sentencia, $valores, $conexion);
        if ($fi == true) {
            header('Location:gestionarTabla.php');
        } else {
            echo 'ERROR';
        }

        break;
    case "Cancelar";
        header('Location:gestionarTabla.php');
        break;
    case "Agregar":
        $tabla = $_SESSION['conexion']['tabla'];
        $sentencia = "select * from $tabla";
        $va = consultarTabla($conexion, $sentencia);
        break;

    case 'Borrar':
        $tabla = $_SESSION['conexion']['tabla'];
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];
        $sentencia = "DELETE FROM $tabla WHERE $campo = ?";
        $valores = [];
        $valores[] = $valor;
        $flag = insertar($sentencia, $valores, $conexion);
        if ($flag == true) {
            header('Location:gestionarTabla.php');
        } else {
            echo 'ERROR';
        }
        break;
    case 'Modificar':
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];
        $tabla = $_SESSION['conexion']['tabla'];
        $sentencia = "select * from $tabla where $campo = ? ";
        echo "select * from $tabla where $campo = $valor";
        $valores = [];
        $valores[] = $valor;
        $va = consultarVlores($sentencia, $valores, $conexion);
        $ver = TRUE;
        break;

    default :
        $tabla = $_SESSION['conexion']['tabla'];
        $sentencia = "select * from $tabla";
        $va = consultarTabla($conexion, $sentencia);
        ;
}

function ver($valor, $ver) {
    if ($ver) {
        echo '';
        return "value = '$valor'";
    } else {
        return "";
    }
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>
        <form action="insetar.php" method="post">
            <fieldset>
                <legend>Gestion de la base de Datos <label id="host"><?php echo $tabla ?></label></legend>
                    <?php
                    foreach ($va as $index => $fila) {
                        foreach ($fila as $campo => $valor) {
                            if ($index == 0) {
                                $campos[] = $campo;
                                echo "sa";
                                echo "$campo <input type='text' name='$campo' " . ver($valor, $ver) . " ><br />";
                            }
                        }
                    }
                    $_SESSION['campos'] = $campos;
                    foreach ($campos as $ca) {
                        $palabras .= "," . $ca;
                    }
                    $final = substr($palabras, 1);
                    echo "<input type='hidden' name='final' value='$final'>";

//                    echo $final;
                    ?>

                <input type="submit" name="opcion" value="Guardar">
                <input type="submit" name="opcion" value="Cancelar">
            </fieldset>
        </form>
    </body>
</html>

