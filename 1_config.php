<?php
include('colegio.php');

$servername = "localhost";
$username = "prueba";
$password = ".q1.w2.e3";
$dbname = "COLEGIO";

//  Crear conexión
$conn = new mysqli($servername, $username, $password);

// Comprobrar conexión
if ($conn->connect_error) {
die("Conexión Fallida: " . $conn->connect_error);
}
echo "Conectado con Éxito";


// Crear una BD:
// YA SE CREÓ UNA VEZ
$sql = "CREATE DATABASE COLEGIO";
if ($conn->query($sql) === TRUE) {
echo "Database creada";
} else {
echo "Error creando database: " . $conn->error;
}


?>