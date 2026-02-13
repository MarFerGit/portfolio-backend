<?php

$usuario=$_REQUEST['usuario'];
$pass=$_REQUEST['pass'];

echo "USUARIO: " .$usuario. "CONTRASEÑA: " .$pass;

//------------------------------
require "conexion.php";

$conn= conectar();

$sql= "SELECT * from usuarios where user='$usuario'";

$resulset=mysqli_query($conn, $sql);

$registro= mysqli_fetch_assoc($resulset);

if(mysqli_affected_rows($conn)>0){
   // echo "Encontro el usuario";
   //verificamos contraseña
   if($pass==$registro['pass']){
       //echo "Contraseña válida";
       //en este punto como validé el usuario inicio sesion

       session_start();
       $_SESSION['id_user']=$registro['id_user'];
       $_SESSION['nombre']=$registro['nombre']. " " .$registro['apellido'];
       $_SESSION['user']=$usuario;
       $_SESSION['rol']=$registro['rol'];

       ////////////////
       //segun el rol es a donde va
        switch($_SESSION['rol']){
            case 1:
                //admin
  
    
                header("location: admin.php");
                break;

            case 2:
                //Profesor
                header ("location: profesor.php");
                break;
            
            default:
                //otra cosa
                echo "Ingresó a un sitio vacio";
                break;
            }


   }
   else{
       header("location: index.php?badPass");
   }
}
else{
    header ("location: index.php?noUsu=$usuario");
}

?>