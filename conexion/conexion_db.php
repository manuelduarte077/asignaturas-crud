<?php

 #Creamos un objeto o instancia de la funcion de mysqli

    $conn = new mysqli('localhost', 'root','','asignaturas');

    if (mysqli_connect_errno()){
        echo 'No se encontro la base de datos', mysqli_connect_error();
        exit();
    } else {
        //echo 'Conectado';
    }