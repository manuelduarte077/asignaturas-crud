<?php

    require 'fpdf/fpdf.php';
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

    #Mostrar las materias
    $vermaterias = "SELECT u.Idusuario, m.id, m.codigoAsignatura, m.nombreAsignatura, m.nota
                        FROM usuarios AS u INNER JOIN asignaturas AS m ON u.Idusuario = m.IdAlumno
                        WHERE u.Idusuario = '$iduser'";
    $resulmaterias = $conn->query($vermaterias);



class PDF extends FPDF {

        function Header()
        {
           // $this->Image();

            $this->SetFont('Arial','B', 15);

            $this->Cell(80);

            $this->Cell(30,10, 'Reporte de Asignatura', 0,0, 'C');

            $this->Ln(20);
        }

        function Footer()
        {
            $this->SetY(-15);

            $this->SetFont('Arial', 'I', 8);

           $this->Cell(0, 10, 'Pagina'.$this->PageNo().'/{nb}',0,0, 'C');
        }

    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFillColor(232,232,230);
    $pdf->SetFont('Times', '', 16);

    $pdf->Cell(40,6, 'Nombre :',0,0, 'C');
    $pdf->Cell(40,6, utf8_decode($row['NombreA']),0,1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Times', 'B', 16);
    $pdf->Cell(40,6, 'CODIGO',1,0, 'C', 1);
    $pdf->Cell(80,6, 'ASIGNATURA',1,0, 'C', 1);
    $pdf->Cell(30,6, 'NOTA',1,1, 'C', 1);

    $pdf->SetFont('Arial', '', 12);

    while ($regmaterias = $resulmaterias->fetch_array(MYSQLI_BOTH)) {
        $pdf->Cell(40,6, utf8_decode($regmaterias['codigoAsignatura']),1,0, 'L');
        $pdf->Cell(80,6, utf8_decode($regmaterias['nombreAsignatura']),1,0, 'L');
        $pdf->Cell(30,6, utf8_decode($regmaterias['nota']),1,1, 'C');
    }

    $pdf->Output('D', 'Asignaturas-'.$row['NombreA'].'-.pdf');

?>

