
<?php
include ('conexion/conexion_db.php');

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
}

#La condicion de niveles de usuarios para asegurar las rutas
$nivel = $_SESSION['tipo_usuario'];

if ($nivel !='1') {
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
    <h4 align="center"> *** Lista de Usuarios *** </h4>

    <table class="table table-bordered table-striped table-hover" id="example"  style=" width=100%">
        <thead class="thead-dark">
        <tr>
            <th>Nombre Completo</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
        </thead>

        <tbody>
        <?php

        while ($regalumnos = $resulalumnos ->fetch_array(MYSQLI_BOTH)) {

            echo '<tr>
                      <td>'.$regalumnos['NombreA'].'</td>
                      <td>'.$regalumnos['NombreU'].'</td>
                      <td>'.$regalumnos['CorreoA'].'</td>    
                      <td><a href="#?id='.$regalumnos['Idusuario'].'" class="btn btn-warning">Editar</a></td>  
                      <td><a href="#?id='.$regalumnos['Idusuario'].'" class="btn btn-danger">Eliminar</a></td>  
                 </tr>';

        }

        ?>
        </tbody>
    </table>


</div>
<?php include 'inc/footer.php'; ?>