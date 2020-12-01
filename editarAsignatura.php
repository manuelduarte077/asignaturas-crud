
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


$alumnos = "SELECT u.Idusuario, a.NombreA, a.CorreoA, u.NombreU 
                    FROM usuarios AS u INNER JOIN alumno AS a ON u.IdAlumno = a.IdAlumno";
$resulalumnos = $conn->query($alumnos);

$ID = $_GET['id'];

$vermaterias ="SELECT id, codigoAsignatura, nombreAsignatura, nota
                    FROM asignaturas 
                    WHERE  id = '$ID'";
$resulmaterias = $conn->query($vermaterias);
$filas = $resulmaterias->fetch_assoc();
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
            <a class="dropdown-item" href="#">Perfil</a>
            <a class="dropdown-item" href="salir.php">Logout</a>
        </div>
    </div>
</nav>


<div class="container p-lg-5" >

    <hr>

    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
        Codigo:<input type="text" name="cod" value="<?php echo $filas['codigoAsignatura'];?>">
        Asinatura: <input type="text" name="asignatura" value="<?php echo $filas['nombreAsignatura'];?>">
        Nota: <input type="number" name="nota" value="<?php echo $filas['nota'];?>">

        <input type="hidden" name="ID" value="<?php echo $ID; ?>">
        <input type="submit" value="Editar" name="editar" class="btn btn-info">
    </form>

</div>

<?php
    if (isset($_POST['editar'])) {
        $cod = $_POST['cod'];
        $asignatura = $_POST['asignatura'];
        $nota = $_POST['nota'];
        $id = $_POST['ID'];

        $sqlModificar = "UPDATE asignaturas SET codigoAsignatura = '$cod',
                                                    nombreAsignatura = '$asignatura',
                                                    nota = '$nota' 
                             WHERE id = '$id'";

        $modificado = $conn->query($sqlModificar);

        if ($modificado>0) {
            echo "<script>
                            alert('Modificado Exitosamente');
                            window.location = 'admin.php';
                         </script>";
        } else {
            echo "<script>
                           alert('Error al modificar');
                           window.location = 'editarAsignatura.php';
                          </script>";
        }

    }

?>

<?php include 'inc/footer.php'; ?>