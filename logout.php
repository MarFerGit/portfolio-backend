<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salir</title>
</head>
<body>
<?php
echo "Hasta Pronto " .$_SESSION['nombre'];

session_destroy();
 
?>

    <a href=index.php><button>VOLVER A INGRESAR</button></a>  
</body>
</html>