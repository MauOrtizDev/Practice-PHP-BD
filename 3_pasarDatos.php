<?php
include('colegio.php');

$servername = "localhost";
$username = "prueba";
$password = ".q1.w2.e3";
$dbname = "COLEGIO";

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);
// sql para crear la tabla

$stmt = $conn->prepare("INSERT INTO Estudiantes (nombre, apellido, ciclo, grado, nota) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre, $apellido, $ciclo, $grado, $nota);

foreach ($COLEGIO as $Ciclo => $grado) {
    foreach ($grado as $numGrado => $infoGrado) {
        foreach ($infoGrado as $alumno) {
            $nombre = $alumno['nombre'];
            $apellido = $alumno['apellido'];
            $ciclo = $Ciclo;
            $grado = $numGrado;
            $nota = $alumno['nota'];
            $stmt->execute();
        }
    }

}


?>