<?php

    include ('conexion/conexion_db.php');

    $ID = $_GET['id'];

    $eliminarAsignatura = "DELETE FROM asignaturas WHERE id = '$ID'";
    $resultado = $conn->query($eliminarAsignatura);

    echo "<script>
               alert('Eliminado Exitosamente');
               window.location = 'admin.php';
          </script>";

    $conn->close();
    ?>