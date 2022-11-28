<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $servername = "localhost";
        $username = "prueba";
        $password = ".q1.w2.e3";
        $dbname = "COLEGIO";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if($conn->connect_error){
            die("Connexión Fallida");
        }

        $sql = "SELECT * from Estudiantes";
        $result = $conn->query($sql);

        if($result->num_rows>0){
            while ($row = $result->fetch_assoc()){
                echo "id: " . $row["id"]. " - Name: " . $row["nombre"]. " " . $row["apellido"]. "<br>";
            }
        }

        $sql = "SELECT * from Estudiantes WHERE grado ='grado11'";
        $result = $conn->query($sql);

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                echo "id: " . $row["id"]. " - Name: " . $row["nombre"]. " " . $row["apellido"]. "<br>";
            }
        }


    ?>
</body>
</html>