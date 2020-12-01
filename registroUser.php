<?php

include 'conexion/conexion_db.php';

$sql = "SELECT IdTipousuario, TipoUsuario FROM tipo_usuario";
$resultado = $conn->query($sql);

if (!empty($_POST)) {
    $nombre  = mysqli_real_escape_string($conn, $_POST['nombrealumno']);
    $usuario = mysqli_real_escape_string($conn, $_POST['user']);
    $genero = $_POST['genero'];
    $tipouser = $_POST['tipouser'];
    $tel = mysqli_real_escape_string($conn, $_POST['telefono']);
    $correo = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_encriptada = sha1($password);

    $sqluser ="SELECT IdUsuario FROM usuarios WHERE NombreU ='$usuario'";
    $resultadouser = $conn->query($sqluser);
    $filas = $resultadouser->num_rows;

    if ($filas>0) {
        echo "<script> 
                      alert('El usuario ya existe');
                      window.location='registroUser.php'; 
              </script>";
    } else {
        $sqlalumno = "INSERT INTO alumno (NombreA, TelefonoA, GeneroA, CorreoA)
                      VALUES ('$nombre', '$tel', '$genero', '$correo')";
        $resultadoAlumno = $conn->query($sqlalumno);
        $idalumno = $conn->insert_id;

        $sqlusuario = "INSERT INTO usuarios (NombreU, PasswordU, IdAlumno, IdTipoUsuario) 
                        VALUES ('$usuario', '$password_encriptada', '$idalumno', '$tipouser')";
        $resultadousuario = $conn->query($sqlusuario);

        if ($resultadousuario>0) {
            echo "<script> 
                      alert('Registro con exito');
                      window.location='index.php'; 
              </script>";
        } else {
            echo "<script> 
                     alert('Error al registrarse');
                      window.location='registroUser.php'; 
              </script>";
        }

    }
}
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
        </ul>
    </div>
</nav>

<main role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3 " align="center">Crear Cuenta</h1>
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNombreA">Nombre del Alumno</label>
                        <input type="text" class="form-control" id="inputNombreA" placeholder="Nombre del Alumno" name="nombrealumno">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputUser">Usuario</label>
                        <input type="text" class="form-control" id="inputUser" placeholder="Usuario" name="user">
                    </div>
                </div>

                <div class="form-row">
                        <label for="inputTipoUser">Tipo de Usuario</label>
                        <select class="form-control" id="inputTipoUser" name="tipouser">
                            <option value="">Seleccione el tipo de Genero</option>
                            <?php
                                while ($fila = $resultado->fetch_assoc()) { ?>
                                    <option value="<?php echo $fila['IdTipousuario'];?>"> <?php echo $fila['TipoUsuario'];?> </option>
                            <?php   } ?>

                        </select>
                </div>


                <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputTelefono">Télefono</label>
                            <input type="tel" class="form-control" id="inputTelefono" placeholder="Número de Télefono" name="telefono">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputGenero">Genero</label>
                                <select class="form-control" name="genero" id="inputGenero">
                                    <option >Seleccione su genero</option>
                                    <option >Femenino</option>
                                    <option >Masculino</option>
                                </select>

                        </div>
                </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email" name="email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Password</label>
                            <input type="password" class="form-control" id="inputPassword4" placeholder="Password" name="password">
                        </div>
                    </div>
                <button type="submit" class="btn btn-primary" name="registar">Registrar</button>
            </form>
        </div>
    </div>

</main>


<?php include 'inc/footer.php';?>

