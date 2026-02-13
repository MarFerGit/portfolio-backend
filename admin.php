<?php
session_start();
if(isset($_SESSION['id_user'])&& $_SESSION['rol']==1){

}
else{
    echo "ACCESO NO AUTORIZADO";
    ?>
    <a href="index.php"><button>VOLVER A INGRESAR</button></a>
    <?php
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM Educación</title>
    <link rel="stylesheet" href="css/estilo.css">
    
    <link rel="stylesheet" href="css/form2.css">
</head>
<body>

    <div class="content">
      
      <header>
      <div class="flexbox-container">
      <div><h1>ABM Educación</h1></div>
      <div style="font-size:0.78em;"><?php
    echo "<h3>Bienvenido " .$_SESSION['nombre']. "</h3>";
    echo "Fecha y Hora";
    //fecha y hora
    date_default_timezone_set('America/Argentina/Buenos_Aires'); 
    $fecha = date('d-m-Y h:i:s a'); 
    echo " ".$fecha. " ";

    ?>
    <form action=logout.php>
        <?php echo "<b> Sesion iniciada como: </b>" .$_SESSION['user']; ?><br>
        <input type=submit value="CERRAR SESION">
    </form></div>
    </div>
        
      </header>
      
      <nav>
        <ul> 
        <li> <a href="#">Alumnos </a>| </li>
        <li><a href="#">Materias</a></li>
</ul>
      </nav>
      
      <section id="content">
      
        <section id="principal">
          <br>
          <article> 
          
        <table>
        <tr>
          <td>
            <div class="container">
            <div class="row"><h1>ALUMNOS</h1>
                </div>
                <form>
                <div class="row">
                <div class="col-25"><label for="nombre">NOMBRE:</label></div>
                <div class="col-75"><input type="text" name="nombre" maxlength="20" placeholder="NOMBRE" required></div>
                </div>
                <div class="row">
                <div class="col-25"><label for="apellido">APELLIDO:</label></div>
                <div class="col-75"><input type="text" name="apellido" maxlength="20" placeholder="APELLIDO" required></div>
                </div>
                <div class="row">
                <div class="col-25"><label for="dni">DNI:</label></div>  
                <div class="col-75"><input type="number" name="dni" placeholder="INGRESE SOLO NUMEROS" required></div>
                </div>
                <div class="row">
                <div class="col-25"><label for="domicilio">DOMICILIO:</label></div>
                <div class="col-75"><input type="text" name="domicilio" maxlength="20" placeholder="DOMICILIO" required></div>
                </div>
                <div class="row">
                <div class="col-25"><label for="telefono">TELEFONO:</label></div>
                <div class="col-75"><input type="text" name="telefono" maxlength="20" placeholder="TELEFONO" required></div>
                </div><br>
                <div class="row">
                <button type="submit" name="AgregarA" value="AgregarA"class="boton">+ AGREGAR ALUMNO</button>
                
                </form>
            </div>
            <form>
            <br><br>
                <a href="admin.php#listarA"><button type=submit value="listarA" name="listarA" class="boton">LISTAR ALUMNOS</button></a><br><br>
                <button type="submit" name="listarA" value="listarA"class="boton">+ VER NOTAS ALUMNOS</button>
                <br><br>
            </form>
            </div>
           </td>    <!-- MATERIAS  --> 
    <td>
            <div class="container">
                <form>
                <div class="row"><h1>MATERIAS</h1>
                </div>
                <div class="row">
                <div class="col-25"><label for="materia">MATERIA:</label></div>
                <div class="col-75"><input type="text" name="materia" maxlength="20" placeholder="MATERIA" required></div>
                </div>
                <div class="row">
                <div class="col-25"><label for="profesor">PROFESOR:</label></div>
                <div class="col-75"><input type="text" name="profesor" maxlength="20" placeholder="NOMBRE COMPLETO PROFESOR" required></div>
                </div>
                
                <div class="row">
                </div>
                <div class="row">
                </div><br>
                <div class="row">
                <button type="submit" name="AltaMateria" value="AltaMateria"class="boton">+ AGREGAR MATERIA</button>
                </div>
                </form>
            <br><br><br><br>
            <form>
            <br><br>
                <button type=submit value="ListarM" name="ListarM" class="boton">LISTAR MATERIAS</button><br><br>
                <button type="submit" name="ListarM" value="ListarM"class="boton">+ VER NOTAS MATERIAS</button>
                <br><br><br></br><br>
            </form>
            </div>
           </td>
        </tr>
        </table>
        
        </article>
        <article>
        <br><br>
        <?php
           require 'clases.php';
           if(isset($_GET['listarA'])){
            echo "LISTADO DE ALUMNOS ";
            echo "<br>";
            ALUMNOS::listarA();
            
        }
        if(isset($_GET['AgregarA'])){
            echo "AGREGAR ALUMNO";
            $alumno = New Alumnos ($_GET['nombre'], $_GET['apellido'], $_GET['dni'],
            $_GET['domicilio'], $_GET['telefono']);
            $alumno->AgregarA();
            
        }
        if(isset($_GET['VerNotasA'])){
            echo "VER NOTAS ALUMNOS";
            Notas::VerNotasxA($_REQUEST['idA']);
        }
        if(isset($_GET['EditarA'])){
            //$id=$_REQUEST['idA'];
            //echo "AQUI EDITAMOS ALUMNO " .$id;
            Alumnos::EditarA($_POST['idA']);
        }
        if(isset($_GET['ActualizarA'])){
            //echo "AQUI ACTUALIZAMOS LOS DATOS DEL ALUMNO";
            $alumno1= New Alumnos ($_REQUEST['nombre'], $_REQUEST['apellido'], $_REQUEST['dni'],
            $_REQUEST['domicilio'], $_REQUEST['telefono']);
            $alumno1->ActualizarA($_REQUEST['idA']);
        }
        if(isset($_GET['EliminarA'])){
            echo "AQUI ELIMINAMOS ALUMNO";
            Alumnos::EliminarA($_REQUEST['idA']);
        }
        ////MATERIAS
        if(isset($_GET['AltaMateria'])){
            echo "AQUI DAMOS DE ALTA UNA MATERIA <br>";
            $materia= New Materias ($_GET['materia'], $_GET['profesor']);
            $materia->AltaMateria();
        }
        if(isset($_GET['ListarM'])){
            echo "AQUI LISTAMOS LAS MATERIAS";
            Materias::ListarMaterias();
        }
        if(isset($_GET['VerNotasM'])){
            echo "AQUI VEMOS NOTAS POR MATERIA";
            Notas::VerNotasM($_REQUEST['cod_M']);
        }
        if(isset($_GET['EditarM'])){
            echo "Editamos Materia";
            Materias::EditarM($_REQUEST['cod_M']);
        }
        if(isset($_GET['ActualizarM'])){
            echo "Guardar cambios";
            $materia1= New Materias ($_REQUEST['materia'], $_REQUEST['profesor']);
            $materia1->ActualizarM($_REQUEST['CodM']);
        }
        if(isset($_GET['EliminarM'])){
            echo "AQUI ELIMINAMOS MATERIA";
            Materias::EliminarM($_REQUEST['cod_M']);
        }
           ?>
           
          
          <br>
    </article>
        </section>
        
      </section>
    
      <footer>
        por Marina Rodriguez
      </footer>
    </div> 
</body>
</html>