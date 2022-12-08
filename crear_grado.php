<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="./main2.js" defer></script>
    <title>INSTITUCIÓN EDUCATIVA "EL GUINEO"</title>
</head>

<body>
    <div class="container text-center">
        <h1>INSTITUCIÓN EDUCATIVA EL GUINEO</h1>
        <h2>Crear Grado</h2>
        <?php
        $servername = "localhost";
        $username = "prueba";
        $password = ".q1.w2.e3";
        $dbname = "COLEGIO";
        $proceder = false;

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo "No se pudo conectar a la Base de Datos";
        } else {
            echo "CONECTADO CON ÉXITO";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="num_grado" class="form-label">Indica el número del grado que deseas crear:</label>
            <input type='number' name='grado' class="form-control" required value=<?= isset($_POST['grado']) ? $_POST['grado'] :
                '' ?>>
            <button class="btn btn-success" type="submit">Crear</button>
        </form>

        <?php
        if (isset($_POST['grado'])) {
            $nuevoGrado = $_POST['grado'];
            $sql = $conn->prepare("SELECT ID from grados where id = $nuevoGrado");

            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                echo "El grado " . $nuevoGrado . " ya existe";
                $proceder = false;
            } else {
                $proceder = true;
                echo $proceder?'true':'false';
                crearGrado($nuevoGrado, $conn);
                
            }

        }
        function crearGrado(int $nuevoGrado, $conn)
        {
            if ($nuevoGrado < 1 || $nuevoGrado > 11) {
                echo "El grado está fuera de los parámetros (entre 1 y 11)";
                return null;
            }
            $peticion = $conn->prepare("SELECT * from todos_los_grados where ID = $nuevoGrado limit 1");
            $peticion->execute();
            $result = $peticion->get_result()->fetch_assoc();
            $id_ciclo = $result['id_ciclo'];
            $nombre_ciclo = $conn->query("SELECT nombre from ciclos where id=$id_ciclo")->fetch_object()->nombre;
            echo "<div><table class='table table-striped'><thead><tr><th scope='col'>GRADO</th><th scope='col'>NOMBRE</th><th scope='col'>CICLO</th><th scope='col'>Estudiantes a ingresar</th></tr></thead>";
            echo "<tr>";
            echo "<td>".$nuevoGrado."</td>";
            echo "<td>".$result['nombre']."</td>";
            echo "<td>".$nombre_ciclo."</td>";
            echo "<td><form><input type='text' class='form-control' name='estudiantes' required></td>";
            echo "</tr>";
            echo "</table></div>";

            echo "<h2>Estudiantes</h2>";
            echo "<table class='table table-striped'>
            <thead>
                <tr>
                    <th scope='col'>APELLIDO</th>
                    <th scope='col'>NOMBRE</th>
                    <th scope='col'>NOTA</th>
                </tr>
            </thead>";
            $terminar = false;
            echo "<tr>
                    <td><input type='text'class='form-control'></td>
                    <td><input type='text'class='form-control'></td>
                    <td><input type='text'class='form-control'></td>"
                    ;






            // POR AQUI VOY
        }
        ?>
    </div>
</body>

</html>