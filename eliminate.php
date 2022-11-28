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
    <title>Modificando Registro</title>
</head>

<body>
    <h1>INSTITUCIÓN EDUCATIVA EL GUINEO</h1>
    <h2>Eliminar Registro:</h2>

    <h4 class="text-danger">¿Estás seguro de eliminar el siguiente registro?</h4>

    <?php
    $servername = "localhost";
    $username = "prueba";
    $password = ".q1.w2.e3";
    $dbname = "COLEGIO";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("NO SE PUEDO CONECTAR");
    }
    if (isset($_POST['si'])) {
        $id = $_POST['si'];
        $sql = "DELETE FROM Estudiantes WHERE id=" . $id;
        if ($conn->query($sql) === TRUE) {
            echo '<script>
            alert("Se eliminó el registro con éxito.");
            window.location.replace("http://localhost/Demo/practiceBD/index.php");
            </script>';
        } else {
            echo "Error en el borrado: " . $conn->error;
        }
    }
    if (isset($_POST['eliminar'])) {
        $id = $_POST['eliminar'];
        $stmt = $conn->prepare("SELECT * from Estudiantes WHERE id=$id");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    }
    ?>

    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>APELLIDO</th>
                <th scope='col'>NOMBRE</th>
                <th scope='col'>CICLO</th>
                <th scope='col'>GRADO</th>
                <th scope='col'>NOTA</th>
            </tr>
        </thead>
        <tr>
            <td>
                <?= $result['apellido'] ?>
            </td>
            <td>
                <?= $result['nombre'] ?>
            </td>
            <td>
                <?= $result['ciclo'] ?>
            </td>
            <td>
                <?= $result['grado'] ?>
            </td>
            <td>
                <?= $result['nota'] ?>
            </td>
        </tr>
    </table>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <button type='submit' class='btn btn-danger' name='si' value=<?= $id ?>>
            <b>SÍ</b>
        </button>
        <button type='button' class='btn btn-primary' name='no'
            onClick="location.href='http://localhost/Demo/practiceBD/index.php'">
            <b>NO</b>
        </button>
    </form>


</body>

</html>