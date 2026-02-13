<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM Educación</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

    <div class="content">
      
      <header>
      <h1>ABM Educación</h1>
      </header>
      
      <nav>
        
      </nav>
      
      <section id="content">
      
        <section id="principal">
          <br>
          <article>
            <div id="ingreso">
            <form action="login.php">
                <input type="text" name="usuario" placeholder="USUARIO" maxlength="20"><br>
                <input type="password" name="pass" placeholder="CONTRASEÑA" maxlength="20"><br>
                <button type="submit">INGRESAR</button>
                
</form>
<?php

if(isset($_GET['noUsu'])){
    echo "<br>El usuario <strong>" .$_GET['noUsu']."</strong> no existe en la base de datos";
}
if(isset($_GET['badPass'])){
    echo "<br>Contraseña inválida";
}

?>
</div>
          </article>
          <br>
        </section>
        
      </section>
    
      <footer>
        por Marina Rodriguez
      </footer>
    </div> 
</body>
</html>