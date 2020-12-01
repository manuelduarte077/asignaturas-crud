
<?php
    include ('conexion/conexion_db.php');

    session_start();
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: index.php');
    }
    #mostar el usuario logeado
    $iduser = $_SESSION['id_usuario'];
    $sql="SELECT u.Idusuario, a.NombreA FROM usuarios AS u INNER JOIN alumno A ON u.IdAlumno = a.IdAlumno
                 WHERE u.Idusuario = '$iduser'";
    $resultado = $conn->query($sql);
    $row = $resultado->fetch_assoc();

    #Registro a la base de datos
    if (!empty($_POST)) {
        $codigo = mysqli_real_escape_string($conn,$_POST['cod']); //para que no se envie algun tipo de codigo malicioso
        $asignatura = mysqli_real_escape_string($conn,$_POST['asignatura']);
        $nota = mysqli_real_escape_string($conn,$_POST['nota']);

        #hACEMOS UNA CONSULTA A LA BASE DE DATOS PARA SABER SI NO EXISTE EL REGISTRO
        $materias ="SELECT id, codigoAsignatura, nombreAsignatura, nota
                    FROM asignaturas 
                    WHERE codigoAsignatura = '$codigo' AND 
                          IdAlumno = '$iduser'";

        $existemateria = $conn->query($materias);
        $filas = $existemateria->num_rows;

        if ($filas>0) {
            echo "<script>    
                        alert('La asignatura ya existe');
                              window.location='admin.php';
                  </script>";
        } else {
            $sqlmateria = "INSERT INTO asignaturas(
                               codigoAsignatura, nombreAsignatura, nota, IdAlumno) 
                               VALUES ('$codigo','$asignatura','$nota', '$iduser')";
            $resulmateria = $conn->query($sqlmateria);

            if ($resulmateria>0) {
                echo "<script> 
                        alert('Registro con exito');
                              window.location='admin.php';
                  </script>";
            } else {
                echo "<script> 
                        alert('Registro con exito');
                              window.location='admin.php';
                  </script>";
            }
        }

    }


    $vermaterias = "SELECT u.Idusuario, m.id, m.codigoAsignatura, m.nombreAsignatura, m.nota
                    FROM usuarios AS u INNER JOIN asignaturas AS m ON u.Idusuario = m.IdAlumno
                    WHERE u.Idusuario = '$iduser'";
    $resulmaterias = $conn->query($vermaterias);

?>

    <?php include 'inc/head.php'; ?>


<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="jumbotron.htm#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="jumbotron.htm#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="jumbotron.htm#">Disabled</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="jumbotron.htm#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="jumbotron.htm#">Action</a>
                    <a class="dropdown-item" href="jumbotron.htm#">Another action</a>
                    <a class="dropdown-item" href="jumbotron.htm#">Something else here</a>
                </div>
            </li>

            <?php
                if ($_SESSION['tipo_usuario']==1) {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="listaUser.php">Lista de Usuarios</a>
                </li>
            <?php } ?>

        </ul>

    </div>


    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $row['NombreA']; ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="perfil.php">Perfil</a>
            <a class="dropdown-item" href="salir.php">Logout</a>
        </div>
    </div>
</nav>


<div class="container p-lg-5" >
    <h3 align="center" class="p-4">Registro de Asignaturas</h3>

    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        Codigo: <input type="text" name="cod" placeholder="CD101" required>
        Asinatura: <input type="text" name="asignatura" placeholder="salud" required>
        Nota: <input type="number" name="nota" placeholder="100" required>

        <input type="submit" value="Guardar" name="guardar" class="btn btn-success">
    </form>

    <hr>
    <h4 align="center"> *** Mis Asignaturas *** </h4>

    <table class="table table-bordered table-striped table-hover" id="example" cellpadding="0" width="100%">
        <thead class="thead-dark">
            <tr>
                <th>Codigo</th>
                <th>Asignatura</th>
                <th>Nota</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>

        <tbody>
                <?php

                    while ($regmaterias = $resulmaterias->fetch_array(MYSQLI_BOTH)) {

                        echo '<tr>
                                    <td>'.$regmaterias['codigoAsignatura'].'</td>
                                    <td>'.$regmaterias['nombreAsignatura'].'</td>
                                    <td>'.$regmaterias['nota'].'</td>  
                                    <td><a href="editarAsignatura.php?id='.$regmaterias['id'].'" class="btn btn-warning">Editar</a></td>  
                                    <td><a href="deleteAsignatura.php?id='.$regmaterias['id'].'" class="btn btn-danger">Eliminar</a></td>  
                                </tr>';

                    }

                ?>
        </tbody>
    </table>

    <div class="btn btn-dark">
        <a href="ReportePDF.php" target="_blank">Imprimir</a>
    </div>

</div>


<?php include 'inc/footer.php'; ?>