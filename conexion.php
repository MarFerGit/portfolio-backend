<?php

function conectar(){
    $serv = "localhost";
    $user="root";
    $pass="";
    $n_db="prueba3Abm";

    $c=mysqli_connect($serv,$user, $pass, $n_db) or 
    die ("No se ha podido conectar a la base de datos");
    return $c;
}



?>