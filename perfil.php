
<?php
include ('conexion/conexion_db.php');

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
}
#mostar el usuario logeado
$iduser = $_SESSION['id_usuario'];
$sql="SELECT u.Idusuario, u.NombreU, u.PasswordU, a.IdAlumno, a.NombreA, a.TelefonoA, a.GeneroA, a.CorreoA
                 FROM usuarios AS u INNER JOIN alumno AS a ON u.IdAlumno = a.IdAlumno
                 WHERE u.Idusuario = '$iduser'";
$resultado = $conn->query($sql);
$row = $resultado->fetch_assoc();


?>

<?php include 'inc/head.php'; ?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="admin.php">Home <span class="sr-only">(current)</span></a>
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
    <h3 align="center" class="p-4">Perfil de Usuarios</h3>

    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputNombreA">Nombre del Alumno</label>
                <input type="text" class="form-control" id="inputNombreA" name="nombrealumno" value="<?php echo $row['NombreA']; ?>">
            </div>

            <div class="form-group col-md-6">
                <label for="inputUser">Usuario</label>
                <input type="text" class="form-control" id="inputUser" name="user" value="<?php echo $row['NombreU']; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputTelefono">Télefono</label>
                <input type="tel" class="form-control" id="inputTelefono" name="telefono" value="<?php echo $row['TelefonoA']; ?>">
            </div>

            <div class="form-group col-md-6">
                <label for="inputGenero">Genero</label>
                <select class="form-control" name="genero" id="inputGenero">
                    <option >Seleccione su genero</option>
                    <option <?php echo $row['GeneroA']==='Masculino' ? "selected='selected'":"" ?> value="Masculino">Masculino</option>
                    <option <?php echo $row['GeneroA']==='Femenino' ? "selected='selected'":"" ?> value="Femenino">Femenino</option>
                </select>

            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input type="email" class="form-control" id="inputEmail4" name="email" value="<?php echo $row['CorreoA']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Password</label>
                <input type="password" class="form-control" id="inputPassword4" name="password" >
            </div>
        </div>
        <input type="hidden" name="ID" value="<?php echo $iduser; ?>">
        <button type="submit" class="btn btn-primary" name="editar">Actualizar</button>
    </form>

    <?php

        if (isset($_POST['editar'])) {
            $nombre = $_POST['nombrealumno'];
            $user = $_POST['user'];
            $telefono = $_POST['telefono'];
            $genero = $_POST['genero'];
            $coreo = $_POST['email'];
            $id = $_POST['ID'];

            if ($_POST['password'] == "") {
                $password = $row ['PasswordU'];
            } else {
                $password = sha1($_POST["password"]);
            }


            $sqlModificar = "UPDATE usuarios AS u INNER  JOIN Alumno AS a ON (u.IdAlumno = a.IdAlumno)
                            SET 
                                u.NombreU = '$user',
                                u.PasswordU = '$password',
                                a.NombreA = '$nombre',
                                a.TelefonoA = '$telefono',
                                a.GeneroA = '$genero',
                                a.CorreoA = '$coreo'
                             WHERE u.Idusuario = '$id'";

            $modificado = $conn->query($sqlModificar);

            if ($modificado>0) {
                echo "<script>
                          alert('Modificado Exitosamente');
                          window.location = 'perfil.php';
                             </script>";
            } else {
                echo "<script>
                               alert('Error al modificar');
                               window.location = 'perfil.php';
                      </script>";
            }

        }

    ?>

</div>
<?php include 'inc/footer.php'; ?>
