
<?php

require 'conexion.php';

Abstract Class Persona{
    protected $nombre;
    protected $apellido;
    protected $dni;

    public function __construct($n, $a, $d){
        $this->nombre=$n;
        $this->apellido=$a;
        $this->dni=$d;
    }

    //MÉTODOS ABSTRACTOS
    abstract public function AgregarA();
    abstract public function listarA();
    abstract public function EditarA($id);
    abstract public function ActualizarA($id);
    abstract public function EliminarA($id);
}

Class Alumnos extends Persona{
    private $domicilio;
    private $telefono;

    public function __construct($nom, $ape, $denei, $dom, $tel){
        parent::__construct($nom, $ape, $denei);
        $this->domicilio=$dom;
        $this->telefono=$tel;
    }

    //MÉTODOS HEREDADOS
    public function AgregarA(){
        $conn= conectar();
        $sql= "INSERT INTO alumnos (nombre, apellido, dni, domicilio, telefono) 
        VALUES ('$this->nombre', '$this->apellido', $this->dni, '$this->domicilio', '$this->telefono');";

        mysqli_query($conn, $sql);

        if(mysqli_affected_rows($conn)>0){
            echo "EL ALUMNO HA SIDO CARGADO CON ÉXITO";
        }else{
            echo "NO SE HA PODIDO CARGAR EL ALUMNO";
        }
    }
    /////
    public function listarA(){
            $conn= conectar();
            $sql= "SELECT * FROM alumnos";

            $registro = mysqli_query($conn, $sql);

            if(mysqli_affected_rows($conn)>0){
                //tabla
                ?>
                <br>
                <table>
                    <tr>
                    <th></th>
                <th>Id Alumno</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Domicilio</th>
                <th>Telefono</th>
                <th>Notas</th>
                <th>Editar</th>
                <th>Eliminar</th>
                    </tr>
                <form method=POST>
                <?php
                //posterior imprimo registro
                while($fila=mysqli_fetch_assoc($registro)){
                    //imprimo registro fila por fila?>
                    <tr>
                    <td>
                    <input type=hidden name=nombre value="<?php echo $fila['nombre']; ?>">
                <input type=hidden name=apellido value="<?php echo $fila['apellido']; ?>" >
                <input type=hidden name=dni value="<?php echo $fila['dni']; ?>" >
                <input type=hidden name=domicilio value="<?php echo $fila['domicilio']; ?>" >
                <input type=radio name=idA value="<?php echo $fila['id_alumno']; ?>" required>
                    </td>
                    <td><?php echo $fila['id_alumno']?></td>
                    <td><?php echo $fila['nombre']?></td>
                    <td><?php echo $fila['apellido']?></td>
                    <td><?php echo $fila['dni']?></td>
                    <td><?php echo $fila['domicilio']?></td>
                    <td><?php echo $fila['telefono']?></td>
                    <td><button formaction="admin.php?VerNotasA" class="notasbtn">NOTAS</button></td>
                    <td><button class="editarbtn" 
                    formaction="admin.php?EditarA">EDITAR</button></td>
                    <td><button class="eliminarbtn" 
                    onclick="return confirm('Estás seguro que deseas eliminar el registro?');" 
                formaction="admin.php?EliminarA">ELIMINAR</button></td>
                    </tr>
                <?php
                }
                ?>
                </form>
                </table>
                <br>
                <?php
            }

    }
    ///////
    public function EditarA($id){
        $conn= conectar();
        $sql= "SELECT * FROM alumnos WHERE id_alumno = $id;";

        $registro= mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn)>0){
            ?>
                <table>
                <tr>
                <th>Id Alumno</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Domicilio</th>
                <th>Telefono</th>
                <th></th>
                </tr>
                <form method=post>
            <?php
            while($fila=mysqli_fetch_assoc($registro)){
                //otra parte de la tabla que cicla mientras haya resultados
                ?>
                <tr>
                <td><input type="hidden" name="idA" value="<?php echo $fila['id_alumno'] ?>"><?php echo $fila['id_alumno'] ?></td>
                <td><input type="text" maxlenght="20" name="nombre" value="<?php echo $fila['nombre']?>" placeholder="<?php echo $fila['nombre']?>"></td>
                <td><input type="text" maxlenght="20" name="apellido" value="<?php echo $fila['apellido']?>" placeholder="<?php echo $fila['apellido']?>"></td>
                <td><input type="number" name="dni" value="<?php echo $fila['dni']?>" placeholder="<?php echo $fila['dni']?>"></td>
                <td><input type="text" name="domicilio" maxlenght="60" value="<?php echo $fila['domicilio']?>" placeholder="<?php echo $fila['domicilio']?>"></td>
                <td><input type="text" name="telefono" maxlenght="20" value="<?php echo $fila['telefono']?>" placeholder="<?php echo $fila['telefono']?>"></td>
                <td><button class="editarbtn" formaction="admin.php?ActualizarA" type=submit>GUARDAR CAMBIOS</button></td>
            </tr>
                <?php
            }  
            ?>
            </form>
            </table>
            <?php
        }
        
        
    }
    /////////
    public function ActualizarA($id){
        $conn=conectar();
        $sql= "UPDATE alumnos set nombre = '$this->nombre', apellido = '$this->apellido', 
        dni = $this->dni, domicilio = '$this->domicilio', telefono = '$this->telefono'  WHERE id_alumno = $id;";

        mysqli_query($conn, $sql);

        if(mysqli_affected_rows($conn)>0){
            echo "<BR>LOS CAMBIOS EN EL ALUMNO: " .$this->nombre. " " .$this->apellido. "<br>HAN SIDO GUARDADOS";
            ?>
            <a href="admin.php"><button class="boton">CONTINUAR</button></a>
            <?php
        }
        else{
            echo "No se han realizado modificaciones en los datos del alumno " .$id;
            ?>
            <a href="admin.php"><button class="btn">CONTINUAR</button></a>
            <?php
        }  
    }
    /////////
    public function EliminarA($id){
            
        $conn= conectar();

        $sql= "delete from alumnos where id_alumno=$id;";

        mysqli_query($conn, $sql);

        if(mysqli_affected_rows($conn)>0){
        echo "<br>El alumno del Id Alumno " .$id. " ha sido eliminado";
         ?>
        <a href="admin.php"><button>VOLVER</button></a>
        <?php
        }else{
        echo "<br>No se pudo eliminar el alumno" .$id;
        ?>
        <a href="admin.php"><button>VOLVER</button></a>
        <?php
        }
    }
    ///////////
}

/////////////////MATERIAS////////////////////////////
Class Materias{
    private $materia;
    private $nombre_prof;

    public function __construct($mat, $prof){
        $this->materia=$mat;
        $this->profesor=$prof;
    }

    ///METODOS
    public function AltaMateria(){
        $conn= conectar();
        $sql= "INSERT INTO materias (materia, nombreCompl_prof) 
        VALUES ('$this->materia', '$this->profesor');";

        mysqli_query($conn, $sql);

        if(mysqli_affected_rows($conn)>0){
            echo "LA MATERIA HA SIDO CARGADO CON ÉXITO";
        }else{
            echo "NO SE HA PODIDO CARGAR LA MATERIA";
        }
    }
    //////////////
    public function ListarMaterias(){
        $conn= conectar();
        $sql= "SELECT * FROM materias";

        $registro=mysqli_query($conn, $sql);

        
        if(mysqli_affected_rows($conn)>0){
            //tabla
            ?>
            <br>
            <table>
                <tr>
                <th></th>
            <th>Cod. Materia</th>
            <th>Materia</th>
            <th>Profesor</th>
            <th>Notas</th>
            <th>Editar</th>
            <th>Eliminar</th>
            </tr>
            <form method=POST>
            <?php
            //posterior imprimo registro
            while($fila=mysqli_fetch_assoc($registro)){
                //imprimo registro fila por fila?>
                <tr>
                <td>
              <input type=hidden name=materia value="<?php echo $fila['materia']; ?>" >
              <input type=hidden name=profesor value="<?php echo $fila['nombreCompl_prof']; ?>" >
              <input type=radio name=cod_M value="<?php echo $fila['cod_mat']; ?>" required>
                </td>
                <td><?php echo $fila['cod_mat']?></td>
                <td><?php echo $fila['materia']?></td>
                <td><?php echo $fila['nombreCompl_prof']?></td>
                <td><button formaction="admin.php?VerNotasM" class="notasbtn">NOTAS</button></td>
                <td><button class="editarbtn" 
                formaction="admin.php?EditarM">EDITAR</button></td>
                <td><button class="eliminarbtn" 
                onclick="return confirm('Estás seguro que deseas eliminar el registro?');" 
              formaction="admin.php?EliminarM">ELIMINAR</button></td>
                </tr>
            <?php
            }
            ?>
            </form>
            </table>
            <br>
            <?php
        }
    }
    ///////////////////////////////////////
    public function EditarM($id){
        $conn= conectar();
        $sql= "SELECT * FROM materias WHERE cod_mat = $id;";

        $registro= mysqli_query($conn, $sql);
        if(mysqli_affected_rows($conn)>0){
            ?>
                <table>
                <tr>
                <th>Cod. Materia</th>
                <th>Materia</th>
                <th>Profesor</th>
                <th></th>
                </tr>
                <form method=post>
            <?php
            while($fila=mysqli_fetch_assoc($registro)){
                //otra parte de la tabla que cicla mientras haya resultados
                ?>
                <tr>
                <td><input type="hidden" name="CodM" value="<?php echo $fila['cod_mat'] ?>"><?php echo $fila['cod_mat'] ?></td>
                <td><input type="text" maxlenght="20" name="materia" value="<?php echo $fila['materia']?>" placeholder="<?php echo $fila['materia']?>"></td>
                <td><input type="text" maxlenght="30" name="profesor" value="<?php echo $fila['nombreCompl_prof']?>" placeholder="<?php echo $fila['nombreCompl_prof']?>"></td>
                <td><button class="editarbtn" formaction="admin.php?ActualizarM" type=submit>GUARDAR CAMBIOS</button></td>
            </tr>
                <?php
            }  
            ?>
            </form>
            </table>
            <?php
        }
    }
    /////////////
    public function ActualizarM($id){
        $conn=conectar();
        $sql= "UPDATE materias set materia = '$this->materia', nombreCompl_prof = '$this->profesor'
          WHERE cod_mat = $id;";

        mysqli_query($conn, $sql);

        if(mysqli_affected_rows($conn)>0){
            echo "<BR>MATERIA  FUE MODIFICADA POR: " .$this->materia. "<br>EL PROFESOR: ". $this->profesor. "<br>HAN SIDO GUARDADOS";
        }
        else{
            echo "<br>No se han realizado modificaciones en los datos de la Materia " .$id;
            ?>
            <a href="admin.php"><button class="boton">CONTINUAR</button></a>
            <?php
        }  
    }
    ///////////////////
        public function EliminarM($id){
            
            $conn= conectar();
    
            $sql= "delete from materias where cod_mat=$id;";
    
            mysqli_query($conn, $sql);
    
            if(mysqli_affected_rows($conn)>0){
            echo "<br>La materia del código: " .$id. " ha sido eliminado";
             ?>
            <a href="admin.php"><button>VOLVER</button></a>
            <?php
            }else{
            echo "<br>No se pudo eliminar la materia " .$id;
            ?>
            <a href="admin.php"><button>VOLVER</button></a>
            <?php
            }
        }
////////////////////////////POR AHORA NO TOMAR EN CUENTA
public function ListarMateriasAlumnos(){
    //va a servir para inscribir a los alumnos en las materias elegidas
            $conn= conectar();
            $sql= "SELECT * FROM materias";
            
            $registro=mysqli_query($conn, $sql);
            
            
                        if(mysqli_affected_rows($conn)>0){
                        //tabla
                        ?>
                        <br>
                        <table>
                            <tr>
                                <td>
                            <tr>
                            <th></th>
                            <th>Cod. Materia</th>
                        <th>Materia</th>
                        <th>Profesor</th>
                        </tr>
                        <form method=POST>
                        <?php
                        //posterior imprimo registro
                        while($fila=mysqli_fetch_assoc($registro)){
                            //imprimo registro fila por fila?>
                            <tr>
                            <td>
                        <input type=radio name=cod_M value="<?php echo $fila['cod_mat']; ?>" required>
                            </td>
                            <td><?php echo $fila['cod_mat']?></td>
                            <td><?php echo $fila['materia']?></td>
                            <td><?php echo $fila['nombreCompl_prof']?></td>
                            </tr>
                        <?php
                        }
                        //$c=conectar();
                        $sql2= "SELECT * FROM alumnos";
                        $resultados=mysqli_query($conn,$sql2);
                        if(mysqli_affected_rows($conn)>0){
                            //tabla
                            ?>
                            <br>
                                <tr>
                                <th></th>
                            <th>Id Alumno</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            </tr>
        
                            <?php
                            //posterior imprimo registro
                            while($fila=mysqli_fetch_assoc($resultados)){
                                //imprimo registro fila por fila?>
                                <tr>
                                <td>
                            <input type=radio name=idA value="<?php echo $fila['id_alumno']; ?>" required>
                                </td>
                                <td><?php echo $fila['id_alumno']?></td>
                                <td><?php echo $fila['nombre']?></td>
                                <td><?php echo $fila['apellido']?></td>
                                <td><button formaction="admin.php?Inscribir" class="notasbtn">SIGUIENTE>></button></td>
                                </tr>
                            <?php
                            }
                            ?>
                            </form>
                            </table>
                            <br>
                            <?php
                        }
                        ?>
                        </form>
                            </td>
                            </tr>
                            <tr><td>
        
                            </td></tr>
                                </table>
                        <br>
                        <?php
                    }
        }
        ///////////////////////////////
}
Class Notas{
    private $idAlumno;
    private $idMateria;
    private $nota1;
    private $nota2;
    private $notafinal;

    public function __construct($idA, $idM, $not1, $not2, $notfnl){
        $this->idAlumno= $idA;
        $this->idMateria= $idM;
        $this->nota1= $not1;
        $this->nota2=$not2;
        $this->notafinal=$notfnl;
    }

///////////////////////METODOS///////////////



public function ListarSOLOMaterias(){
        $conn= conectar();
        $sql= "SELECT * FROM materias";

        $registro=mysqli_query($conn, $sql);

        
        if(mysqli_affected_rows($conn)>0){
            //tabla
            ?>
            <br>
            
            <h1>ELEGIR MATERIA</h1>
            <table>
                <tr>
                <th></th>
            <th>Cod. Materia</th>
            <th>Materia</th>
            <th>Profesor</th>
            <th></th>
            <th></th>
            </tr>
            <form method=POST> 
            <?php
            //posterior imprimo registro
            while($fila=mysqli_fetch_assoc($registro)){
                //imprimo registro fila por fila?>
               
               <tr>
                <td>
                
            <input type=radio name=cod_M value="<?php echo $fila['cod_mat']; ?>" required>
            <input type=hidden name=materia value="<?php echo $fila['materia']; ?>" >
            <input type=hidden name=profesor value="<?php echo $fila['nombreCompl_prof']; ?>" >
                </td>
                <td><?php echo $fila['cod_mat']?></td>
                <td><?php echo $fila['materia']?></td>
                <td><?php echo $fila['nombreCompl_prof']?></td>
                <td><button formaction="profesor.php?VerNotasM" class="notasbtn">VER NOTAS</button></td>
                <td><button formaction="profesor.php?ListarAlumnos" class="notasbtn">SIGUIENTE PARA CARGAR NOTAS</button></td>
                </tr>
                
            <?php
            
           }
            ?>
            </form>
            </table>
            <br>
            <?php
        }
}
//////////////////////////

public function ListarAlumnos($cod_mat){
        
    
        
        echo "<h2> CÓDIGO MATERIA" .$cod_mat;
        
        
        $c=conectar();
        $sql="SELECT id_alumno, nombre, apellido FROM alumnos";
        $resultado=mysqli_query($c,$sql);

        if(mysqli_affected_rows($c)>0){
            //imprimo la tabla
            ?>
            <table>
                
                <tr>
                    <th></th>
                <th>Id Alumno</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Nota 1</th>
                <th>Nota 2</th>
                <th></th>
                <th></th>
                </tr>
                <tr>
                
                    <?php
                    while($fila=mysqli_fetch_assoc($resultado)){
                    ?> 
                    <form method=post>
                <td><input type="radio" name="idA" value="<?php echo $fila['id_alumno']?>" required>
                    
                </td>
                <td><?php echo $fila['id_alumno']?></td>
                <td><?php echo $fila['nombre']?></td>
                <td><?php echo $fila['apellido']?></td>
                <td><input type="number" step="0.25" name="nota1"  placeholder="nota1" required></td>
                <td><input type="number" step="0.25" name="nota2"  placeholder="nota2"required></td>
                <td><input type="hidden" step="0.25" value="0" name="notafinal" placeholder="notafinal"></td>
                <input type="hidden" name="idM" value="<?php echo $cod_mat?>">
                <td><button class="editarbtn" formaction="profesor.php?CargarN">CARGAR NOTA/S</button></td>
                </tr>
                </form>
                    <?php } ?>
                    
        </table>
            <?php
        }
    }

///////////////////////
public function CargarN(){
        echo $this->idAlumno. " " .$this->idMateria. " ".$this->nota1. " ".$this->nota2. " " .$this->notafinal;
        $conn= conectar();
            $sql= "INSERT INTO notas (id_alumno, cod_mat, nota1, nota2, notafinal) 
            VALUES ($this->idAlumno, $this->idMateria, $this->nota1, $this->nota2, $this->notafinal);";
            
            mysqli_query($conn, $sql);

            if(mysqli_affected_rows($conn)>0){
                echo "LAS NOTA/S HA SIDO CARGADO CON ÉXITO<br>";
                if($this->nota1<4 || $this->nota2<4){
                    echo "ALUMNO DESAPROBADO";
                    
                }else {
                    echo "Puede cargar la nota final del alumno" .$this->idAlumno. 
                    "<br> debido a que aprobó la cursada en la materia " .$this->idMateria;
                    ?>
                    <form method=post>  
                    <button formaction="profesor.php?VerNotasA" class="boton">IR</button>
                </form>
                    <?php
                }
            }else{
                echo "NO SE HAN PODIDO CARGAR LA/S NOTAS";
            }
    }
///////////////////////
public function VerNotasA(){
    $c=conectar();
    $sql="SELECT alumnos.id_alumno AS id_alumnoALUMNOS, 
            alumnos.nombre AS nombreALUMNOS, alumnos.apellido AS apellidoALUMNOS,
            notas.id_notas AS id_notasNOTAS,
            notas.cod_mat AS cod_matNOTAS, notas.nota1 AS nota1NOTAS, notas.nota2 AS nota2NOTAS, 
            notas.notafinal AS notafinalNOTAS    
            FROM alumnos RIGHT JOIN notas ON notas.id_alumno = alumnos.id_alumno;";

    $resultado=mysqli_query($c,$sql);
    if(mysqli_affected_rows($c)>0){
    ?>
    <table>
                <tr>
                <th></th>
            <th>Id Alumno</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Materia</th>
            
            <th>Nota 1</th>
            <th>Nota 2</th>
            <th>Nota Final</th>
            <th></th>
            <th></th>
            </tr>
            <form method=post>
            <tr>
                <?php while($fila=mysqli_fetch_assoc($resultado)){
                ?>
            <td><input type="radio" name="idN" value="<?php echo $fila['id_notasNOTAS']?>" required></td>
            <td><?php echo $fila['id_alumnoALUMNOS']?></td>
            <td><?php echo $fila['nombreALUMNOS']?></td>
            <td><?php echo $fila['apellidoALUMNOS']?></td>
            <td><?php echo $fila['cod_matNOTAS']?></td>
            <td><?php echo $fila['nota1NOTAS']?></td>
            <td><?php echo $fila['nota2NOTAS']?></td>
            <td><?php echo $fila['notafinalNOTAS']?></td>
            <td><button formaction="profesor.php?EditarN"class="notasbtn">EDITAR</button></td>
            <td><button class="notasbtn" onclick="return confirm('Estás seguro que deseas eliminar el registro?');" 
              formaction="profesor.php?EliminarN">ELIMINAR</button></td>
            
            </tr> 
            <?php } ?>           
        </form>
    </table>
    <?php
    }else{
        echo" AUN NO SE REGISTRARON DATOS ";
        ?>
    <a href="profesor.php"><button class="boton">VOLVER</button></a>
    <?php
    }
}
//////////////////////////////////
public function VerNotasM($idM){
    $c=conectar();
    $sql="SELECT alumnos.id_alumno AS id_alumnoALUMNOS, 
            alumnos.nombre AS nombreALUMNOS, alumnos.apellido AS apellidoALUMNOS,
            notas.cod_mat AS cod_matNOTAS, notas.nota1 AS nota1NOTAS, notas.nota2 AS nota2NOTAS, 
            notas.notafinal AS notafinalNOTAS    
            FROM alumnos RIGHT JOIN notas ON notas.id_alumno = alumnos.id_alumno 
            WHERE notas.cod_mat = $idM;";

    $resultado=mysqli_query($c,$sql);
    if(mysqli_affected_rows($c)>0){
    ?>
    <table>
            <tr>
            <!--<th></th>-->
            <th>Cod. Materia</th>
            <th>Id Alumno</th>
            <th>Nombre</th>
            <th>Apellido</th>
            
            
            <th>Nota 1</th>
            <th>Nota 2</th>
            <th>Nota Final</th>
            <!--<th></th>
            <th></th>-->
            </tr>
        
            <tr>
                <?php while($fila=mysqli_fetch_assoc($resultado)){
                ?>
                <form>
            <!--<td><input type="radio" name="CodM" value="<?php echo $fila['cod_matNOTAS']?>" required></td>-->
            <td><?php echo $fila['cod_matNOTAS']?></td>
            <td><?php echo $fila['id_alumnoALUMNOS']?></td>
            <td><?php echo $fila['nombreALUMNOS']?></td>
            <td><?php echo $fila['apellidoALUMNOS']?></td>
            <td><?php echo $fila['nota1NOTAS']?></td>
            <td><?php echo $fila['nota2NOTAS']?></td>
            <td><?php echo $fila['notafinalNOTAS']?></td>
            <!--<td><button formaction="profesor.php?EditarN" class="notasbtn">EDITAR</button></td>
            <td><button formaction="profesor.php?EliminarM" class="notasbtn">ELIMINAR</button></td>-->
            </form>
            </tr> 
            <?php } ?>           
        
    </table>
    <?php
    
    }else{
        
        echo" AUN NO SE REGISTRARON DATOS PARA LA MATERIA " .$idM;
        
    }
}

////////////////EDITAR NOTAS/////////////////
public function EditarN($id){
    $conn= conectar();
    $sql= "SELECT * FROM notas WHERE id_notas = $id;";

    $registro= mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn)>0){
        ?>
            <table>
            <tr>
            <th>Id Nota</th>
            <th>Id alumno</th>
            <th>Cod. Materia</th>
            <th>Nota 1</th>
            <th>Nota 2</th>
            <th>Nota Final</th>
            <th></th>
            </tr>
            
            <form method=post>
        <?php
        while($fila=mysqli_fetch_assoc($registro)){
            //otra parte de la tabla que cicla mientras haya resultados
            //si cumple la condición
            if($fila['nota1']>=4 && $fila['nota2']>=4){
            ?>
            <tr>
            <td><input type="hidden" name="idN" value="<?php echo $fila['id_notas'] ?>">
            <input type="hidden" name="idA" value="<?php echo $fila['id_alumno'] ?>">
            <input type="hidden" name="CodM" value="<?php echo $fila['cod_mat'] ?>">            
            
            <?php echo $fila['cod_mat'] ?></td>
            <td><input type="hidden" name="idA" value="<?php echo $fila['id_alumno'] ?>"><?php echo $fila['id_alumno'] ?></td>
            <td><?php echo $fila['id_alumno'] ?></td>
            <td><input type="number" step="0.25" name="nota1" value="<?php echo $fila['nota1']?>" ></td>
            <td><input type="number" step="0.25" name="nota2" value="<?php echo $fila['nota2']?>" ></td>
            <td><input type="number" step="0.25" name="notafinal" value="<?php echo $fila['notafinal']?>" ></td>
            <td><button class="editarbtn" formaction="profesor.php?ActualizarN" type=submit>GUARDAR CAMBIOS</button></td>
        </tr>
            <?php
            }else{
                ?>
            <tr>
            <td><input type="hidden" name="idN" value="<?php echo $fila['id_notas'] ?>">
            <input type="hidden" name="idA" value="<?php echo $fila['id_alumno'] ?>">
            <input type="hidden" name="CodM" value="<?php echo $fila['cod_mat'] ?>">            
            
            <?php echo $fila['cod_mat'] ?></td>
            <td><input type="hidden" name="idA" value="<?php echo $fila['id_alumno'] ?>"><?php echo $fila['id_alumno'] ?></td>
            <td><?php echo $fila['id_alumno'] ?></td>
            <td><input type="number" step="0.25" name="nota1" value="<?php echo $fila['nota1']?>" ></td>
            <td><input type="number" step="0.25" name="nota2" value="<?php echo $fila['nota2']?>" ></td>
            <td>ESTE ALUMNO HA DESAPROBADO LA MATERIA
            <input type="hidden" name="notafinal" value="0" ></td>
            <td><button class="editarbtn" formaction="profesor.php?ActualizarN" type=submit>GUARDAR CAMBIOS</button></td>
        </tr>
            <?php
            }
        }  
        ?>
        </form>
        </table>
        <?php
    }
}
////////////////////////////////////////////
public function ActualizarN($id){
    echo "<BR>LAS NOTAS: " .$this->nota1. " ". $this->nota2. " " .$this->notafinal;
    $conn=conectar();
    $sql= "UPDATE notas set nota1 = $this->nota1, nota2 = $this->nota2, notafinal = $this->notafinal
      WHERE id_notas = $id;";

    mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)>0){
        echo "<BR>LAS NOTAS: " .$this->nota1. " ". $this->nota2. " " .$this->notafinal;
    }
    else{
        echo "<br>No se han realizado modificaciones en los datos de las Notas ID: " .$id;
        ?>
        <a href="profesor.php"><button class="boton">CONTINUAR</button></a>
        <?php
    }  
}
/////////////////////////////
public function EliminarN($id){
            
    $conn= conectar();

    $sql= "DELETE from notas WHERE id_notas=$id;";

    mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn)>0){
    echo "<br>El registro Id NOTAS " .$id. " HA SIDO ELIMINADO";
     ?>
    <a href="profesor.php"><button>VOLVER</button></a>
    <?php
    }else{
    echo "<br>No se pudo eliminar el registro";
    ?>
    <a href="profesor.php"><button class="boton">VOLVER</button></a>
    <?php
    }
}
//////////////////////////////
public function VerNotasxA($id){
    $c=conectar();
    $sql="SELECT alumnos.id_alumno AS id_alumnoALUMNOS, 
            alumnos.nombre AS nombreALUMNOS, alumnos.apellido AS apellidoALUMNOS,
            notas.cod_mat AS cod_matNOTAS, notas.nota1 AS nota1NOTAS, notas.nota2 AS nota2NOTAS, 
            notas.notafinal AS notafinalNOTAS    
            FROM alumnos RIGHT JOIN notas ON notas.id_alumno = alumnos.id_alumno 
            WHERE notas.id_alumno = $id;";

    $resultado=mysqli_query($c,$sql);
    if(mysqli_affected_rows($c)>0){
    ?>
    <table>
            <tr>
            <!--<th></th>-->
            <th>Id Alumno</th>
            <th>Cod. Materia</th>
            <th>Nombre</th>
            <th>Apellido</th>
            
            
            <th>Nota 1</th>
            <th>Nota 2</th>
            <th>Nota Final</th>
            <!--<th></th>
            <th></th>-->
            </tr>
        
            <tr>
                <?php while($fila=mysqli_fetch_assoc($resultado)){
                ?>
                <form>
                    <td><?php echo $fila['id_alumnoALUMNOS']?></td>
                    <td><?php echo $fila['cod_matNOTAS']?></td>
                    <td><?php echo $fila['nombreALUMNOS']?></td>
                    <td><?php echo $fila['apellidoALUMNOS']?></td>
                    <td><?php echo $fila['nota1NOTAS']?></td>
                    <td><?php echo $fila['nota2NOTAS']?></td>
                    <td><?php echo $fila['notafinalNOTAS']?></td>
                </form>
            </tr> 
            <?php } ?>           
        
    </table>
    <?php
    }else{
        echo" AUN NO SE REGISTRARON DATOS PARA LA MATERIA " .$id;
        ?>
    <a href="admin.php"><button class="boton">VOLVER</button></a>
    <?php
    }
}
/////////////////FIN CLASES NOTAS/////////////////////////

}


?>


