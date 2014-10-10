<?php

function dbConnect($usertype, $connectionType = "mysqli") {
    $host = "localhost";
    $db = "jasa";
    if ($usertype == "read") {
        $user = "read";
        $password = "abcd32";
    } elseif ($usertype == "write") {
        $user = "root";
        $password = "jasa";
        //$password = "tecno13#."; 
    } else {
        exit("Modo no reconocido");
    }
    if ($connectionType == "mysqli") {
        $connection = new mysqli($host, $user, $password, $db);
        return $connection;
    } else {
        try {
            $connection = new PDO("mysql:host:$host;dbname=$db", $username, $password) or die("No es posible acceder a la base de datos");
            return $connection;
        } catch (PDOException $e) {
            echo "No es posible acceder a la base de datos";
            exit;
        }
    }
}
