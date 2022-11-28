<?php
include('colegio.php');

$servername = "localhost";
$username = "prueba";
$password = ".q1.w2.e3";
$dbname = "COLEGIO";

// Crear conexión

$conn = new mysqli($servername, $username, $password, $dbname);
// sql para crear la tabla

$sql = "CREATE TABLE Estudiantes (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    apellido VARCHAR(30) NOT NULL,
    ciclo VARCHAR(50),
    grado VARCHAR(50),
    nota DOUBLE(1, 1),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Tabla Estudiantes creada";
    } else {
        echo "Error creando tabla: " . $conn->error;
    }

?>