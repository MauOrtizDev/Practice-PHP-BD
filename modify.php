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
    
    <h2>Modificar registro de estudiante:</h2>

    <?php
    $servername = "localhost";
    $username = "prueba";
    $password = ".q1.w2.e3";
    $dbname = "COLEGIO";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("NO SE PUEDO CONECTAR");
    }

    if (isset($_POST['modificar'])) {
        $idmodify = $_POST['modificar'];
        $stmt = $conn->prepare("SELECT * from Estudiantes WHERE id=$idmodify");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    }
        isset($_POST['grado']) ? $infoGrado = explode('-', $_POST['grado']) : ["",""];

    $apellido = $result['apellido'] ?? $_POST["apellido"] ?? "";
    $nombre = $result['nombre'] ?? $_POST["nombre"] ?? "";
    $grado = $result['grado'] ?? $infoGrado[1] ?? "";
    $nota = $result['nota'] ?? $_POST["nota"] ?? "";
    ?>

    <?php if (isset($_POST["apellido"])) {

    // $infoGrado = explode(';', $_POST['grado']) ?? ["",""];  
    $apellido = $_POST["apellido"];
    $nombre = $_POST["nombre"];
    $grado = $_POST["grado"];
    $nota = $_POST["nota"];
    $id = $_POST['id'];
    $sePuedeEnviar = true;

    if (!preg_match("/^[A-zÀ-ú]*$/", $apellido)) {
        $apellErr = "No se admiten espacios, números ni caracteres espaciales.";
        $sePuedeEnviar = false;
    }
    if (!preg_match("/^[A-zÀ-ú]*$/", $nombre)) {
        $nombErr = "No se admiten espacios, números ni caracteres espaciales.";
        $sePuedeEnviar = false;
    }
    if (filter_var($nota, FILTER_VALIDATE_FLOAT, ["options" => ["min_range" => 1, "max_range" => 5]]) === false) {
        $notaErr = "Introduzca un número válido entre 1.0 y 5.0";
        $sePuedeEnviar = false;
    }
    if ($sePuedeEnviar) {
        $sql = "UPDATE Estudiantes SET apellido=?, nombre=?, grado=?, nota=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $apellido, $nombre, $grado, $nota, $id);
        $stmt->execute();
        echo '<script>
            alert("Actualización llevada a cabo con éxito.");
            window.location.replace("http://localhost/Demo/practiceBD/index.php");
            </script>';
    }
}
?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mx-5 col-6">
        <div class="mb-3">
            <label for="apellido" class="form-label">APELLIDO</label>
            <input type="text" class="form-control" name="apellido" value='<?= $apellido ?>' required>
            <div class="form-text text-danger">
                <?= $apellErr ?? "" ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">NOMBRE</label>
            <input type="text" class="form-control" name="nombre" value='<?= $nombre ?>' required>
            <div class="form-text text-danger">
                <?= $nombErr ?? "" ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="grado" class="form-label">GRADO</label>
            <select class="form-select" name="grado">
            <?php
                $sql = "SELECT * from ciclos";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <optgroup label=<?=$row['nombre']?>>
                            <?php
                            $id_ciclo = $row['ID'];
                            $sql2 = "SELECT * from grados where id_ciclo = $id_ciclo";
                            $result2 = $conn->query($sql2);
                            if ($result2->num_rows > 0){
                        while ($row2 = $result2->fetch_assoc()) {
                            ?>
                            <option value=<?=$row2['ID']?> <?= $grado==$row2['ID'] ? 'selected' : '' ?>><?=$row2['nombre']?></option>
                            <?php
                        }
                            }

                    }
                }
                ;
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="nota" class="form-label">PROMEDIO</label>
            <input type="text" class="form-control" name="nota" value='<?= $nota ?>' required>
            <div class="form-text text-danger">
                <?= $notaErr ?? "" ?>
            </div>
        </div>
        <button class="btn btn-success" type="submit" name="id" value=<?= $idmodify ?? "" ?>>MODIFICAR</button>
        <button class="btn btn-primary" type="button" name="id" onClick="location.href='http://localhost/Demo/practiceBD/index.php'">Volver</button>
    </form>

</body>

</html>