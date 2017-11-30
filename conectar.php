<?php

function show_msj() {
    global $msj;
    echo"HOLA MUNDO";
    return $msj;
   
}

/**
 *
 * @param type $host el nombre del host
 * @param type $user el identificador del usuario
 * @param type $pass el password del usuario
 * @return \PDO
 */
function conectar($host, $user, $pass) {
    global $msj;
    $con = null;
    try {
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $con = new PDO("mysql:host=$host", $user, $pass, $opciones);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        $msj = ("No se ha podido conectar a la BD" . $ex->getMessage());
    }
    return $con;
}

function conectarBase($host, $base, $user, $pass) {
    try {
        $con = new PDO("mysql:host=$host;dbname=$base;'charset=UTF-8'", $user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        $con = ("No se ha podido conectar a la BD" . $ex->getMessage());
    }
    return $con;
}

function consultar($con, $sentencia) {
    $result = [];
    $stmt = $con->query($sentencia);
    //echo $sentencia     ;
    //$stmt->execute();
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $result[] = $fila['Database'];
    }
    return $result;
}

function consultarBase($con, $sentencia) {
    $result = [];
    $stmt = $con->query($sentencia);

    while ($fila = $stmt->fetch(PDO::FETCH_NUM)) {
        $result[] = $fila[0];
    }
    return $result;
}

function consultarTabla($con, $sentencia) {
    $result = [];
    $stmt = $con->query($sentencia);
    //echo $sentencia     ;
    //echo "tiene $n columnas <br />";
    //$stmt->execute();
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $fila;
    }
    return $result;
}

function consultarVlores($sentencia, $valores, $con) {
    try {
        $resultado = [];
        //Obtenemos un PDOStatment
        $stmt = $con->prepare($sentencia);
        //Ejecutamos la consulta(I-D-U)
        $stmt->execute($valores);
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultado[] = $fila;
        }
    } catch (PDOException $e) {

    }

    return $resultado;
}

function insertar($sentencia, $valores, $con) {
    //Obtenemos un PDOStatment
    try {
        $stmt = $con->prepare($sentencia);

//    $stmt = $con->prepare("INSERT INTO familia VALUES(?, ?)");
//    $stmt = bindParam(1, "1");
//    $stmt = bindParam(2, "1");
//
        //Ejecutamos la consulta(I-D-U)
        $i = 1;
        foreach ($valores as $va) {
            echo $va;
//            $gsent->bindValue(1, $va, PDO::PARAM_STR);
//            $i++;
        }
        $stmt->execute($valores);
        //Obtenemos el numero de filas insetadas
        $filas = ($stmt->rowCount() == 1) ? true : false;
    } catch (PDOException $e) {
        echo "Error " . $e->getMessage() . "<br />";
    }
    return $filas;
}

?>
