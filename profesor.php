<?php
session_start();
if(isset($_SESSION['id_user'])&& $_SESSION['rol']==2){

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
        <?php echo "<b> Sesion iniciada como: </b>" .$_SESSION['user']; ?>
        <input type=submit value="CERRAR SESION">
    </form></div>
    </div>
        <table>
            <tr>
      <td></td>
      <td style="font-size:0.78em;"></td>
</tr>
</table>
      </header>
      
      <nav>
        <ul> 
        <li><form><button type="submit" name="ListarMat" value="ListarMat"class="boton">+ CARGAR NOTA</button><br>
              </form></li>
              <li><form><button type="submit" name="VerNotasA" value="VerNotasA"class="boton">CONTROL NOTAS ALUMNOS </button></form></li>
              <li><form><button type="submit" name="ListarMat" value="ListarMat"class="boton">+ LISTAR NOTAS MATERIAS </button></form></li>
        
</ul>
      </nav>
      
     
            <section id="content">
      
      <section id="principal">
        <br>
        <article> 
        
        
      <table>
      <tr>
        <td colspan=3>
          <div class="container">
          <div class="row"><h1></h1>
              </div>
        </td>
              <tr>
                <tr>
                  <td>
              
              <div class="row">
                
                <br>
              <?php require "clases.php";
              if(isset($_GET['ListarMat'])){
                Notas::ListarSOLOMaterias();
              }
              ?>
              </div>
                  </td>                
                <td>
                <div class="row">
              
                </div>
                </td>
              <tr><td colspan=2>
        <div class="row">
          <br>
          <?php
          if(isset($_REQUEST['ListarAlumnos'])){
            /*$idM=$_REQUEST['cod_M'];
            echo $idM;
            $materia=$_REQUEST['materia'];
            echo $materia;*/
            Notas::ListarAlumnos($_REQUEST['cod_M']);
            //echo $cod_mat;
          }
          if(isset($_REQUEST['CargarN'])){
            /*$idA=$_REQUEST['idA'];
            $idM=$_REQUEST['idM'];
            $n1= $_REQUEST['nota1'];
            $n2=$_REQUEST['nota2'];
            $nf= $_REQUEST['notafinal'];
            echo $idA. $idM. $n1. $n2. $nf;
            echo $n1;*/
            $notas= New Notas ($_REQUEST['idA'], $_REQUEST['idM'], $_REQUEST['nota1'], $_REQUEST['nota2'], 
            $_REQUEST['notafinal']);
            $notas->CargarN();
          }
          if(isset($_GET['VerNotasA'])){
            //echo "MOSTRAMOS LAS NOTAS";
            Notas::VerNotasA();
          }
          
          if(isset($_GET['VerNotasM'])){
            //echo "MOSTRAMOS LAS NOTAS";
            Notas::VerNotasM($_REQUEST['cod_M']);
          }
          if(isset($_REQUEST['EditarN'])){
            echo "EDITAMOS LAS NOTAS ";
            Notas::EditarN($_REQUEST['idN']);
          }
          if(isset($_REQUEST['ActualizarN'])){
            echo "EDITAMOS LAS NOTAS ";
            //$n1= $_REQUEST['nota1'];
            //echo $n1;
            $notas1= New Notas($_REQUEST['idA'], $_REQUEST['CodM'], $_REQUEST['nota1'], $_REQUEST['nota2'], $_REQUEST['notafinal']);
            $notas1->ActualizarN($_REQUEST['idN']);
          }
          if(isset($_REQUEST['EliminarN'])){
            echo "ELIMINAMOS EL REGISTRO";
            Notas::EliminarN($_REQUEST['idN']);
          }

          ?><BR>
        </div></td>
      </tr>
          </div> 
  
      </tr>
      
      </table>
      
      </article>
<article>
          </article>
        </section>
        
      </section>
    
      <footer>
        por Marina Rodriguez
      </footer>
    </div> 
</body>
</html>