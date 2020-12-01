<?php

    include 'conexion/conexion_db.php';

    session_start();
    if (isset($_SESSION['id_usuario'])) {
        header('Location: admin.php');
    }

    if (!empty($_POST)) {
        $usuario = mysqli_real_escape_string($conn, $_POST['user']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
        $password_encriptada = sha1($password);
        $sql = "SELECT IdUsuario, IdTipoUsuario FROM usuarios WHERE NombreU = '$usuario' AND PasswordU = '$password_encriptada'";

        $resultado = $conn->query($sql);
        $filas = $resultado->num_rows;

        if ($filas>0) {
            $fila=$resultado->fetch_assoc();
            $_SESSION['id_usuario']=$fila['IdUsuario'];
            $_SESSION['tipo_usuario']=$fila['IdTipoUsuario'];
            header("Location: admin.php");
        } else {
            echo "<script> 
                      alert('El Usuario o Password son incorrectos');
                      window.location='index.php'; 
              </script>";
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
        <form class="form-inline my-2 my-lg-0" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <a href="registroUser.php"> Crear Cuenta: </a>
            <input class="form-control mr-sm-2" type="text" name="user" placeholder="Nombre de usuario" >
            <input class="form-control mr-sm-2" ype="password" name="pass" placeholder="Password">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="ingresar">Ingresar</button>
        </form>
    </div>
</nav>

<main role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">Hello, world!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a class="btn btn-primary btn-lg" href="jumbotron.htm#" role="button">Learn more &raquo;</a></p>
        </div>
    </div>

    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="jumbotron.htm#" role="button">View details &raquo;</a></p>
            </div>
            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="jumbotron.htm#" role="button">View details &raquo;</a></p>
            </div>
            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                <p><a class="btn btn-secondary" href="jumbotron.htm#" role="button">View details &raquo;</a></p>
            </div>
        </div>

        <hr>

    </div> <!-- /container -->

</main>


<?php include 'inc/footer.php';?>
