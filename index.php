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

    <h1>INSTITUCIÓN EDUCATIVA EL GUINEO</h1>
    <h2>Mostrar base de datos de Estudiantes:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="ciclo">Ciclo</label>
        <?php
        function verificarSeleccionado($name, $key)
        {
            $selected = (isset($_POST[$name]) && $_POST[$name] == $key) ? 'selected' : '';
            return $selected;
        }
        ?>
        <?php
        $options = [
            'Todos' => 'Todos',
            'Primaria' => 'Primaria',
            'Secundaria' => 'Secundaria',
        ];
        ?>

        <select name="ciclo" id="ciclo">
            <?php foreach ($options as $key => $label) { ?>
            <option value="<?= $key ?>" <?= verificarSeleccionado('ciclo', $key); ?>><?= $label ?>
            </option>
            <?php } ?>
        </select>
        <label for="secundaria" id="labelGrado">Grados</label>

        <?php
        $options = [
            'Todos' => 'Todos',
            'grado10' => 'Grado 10',
            'grado11' => 'Grado 11',
        ];
        ?>

        <select name="secundaria" id="secundaria" <?='style="display:inline;"' ?>>
            <?php foreach ($options as $key => $label) { ?>
            <option value="<?= $key ?>" <?= verificarSeleccionado('secundaria', $key); ?>><?= $label ?>
            </option>
            <?php } ?>
        </select>

        <?php

        /**
         * TABLE: Grados
         * ID
         * nombre_del_grado
         * identificacion: grado3
         * 
         * Crear un seccion en el sistema qu enos permita añadir nuevos grados (CRUD)
         * Reasignar estudiantes del grado a otro grado
        */
        $options = [
            'Todos' => 'Todos',
            'grado3' => 'Grado 3',
            'grado4' => 'Grado 4',
            'grado5' => 'Grado 5',
        ];
        ?>

        <select name="primaria" id="primaria">
            <?php foreach ($options as $key => $label) { ?>
            <option value="<?= $key ?>" <?= verificarSeleccionado('primaria', $key); ?>><?= $label ?>
            </option>
            <?php } ?>
        </select>
        <label for="orden" id="orden">Orden:</label>
        <?php
        $options = [
            'ID' => 'Por defecto',
            'apellido' => 'Por apellidos',
            'nota' => 'Por promedio',
        ];
        ?>

        <select name="orden" id="orden">
            <?php foreach ($options as $key => $label) { ?>
            <option value="<?= $key ?>" <?= verificarSeleccionado('orden', $key); ?>><?= $label ?>
            </option>
            <?php } ?>
        </select>
        <br>
        <input type="submit" value="MOSTRAR">
    </form>
    <?php
    $servername = "localhost";
    $username = "prueba";
    $password = ".q1.w2.e3";
    $dbname = "COLEGIO";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo "No se pudo conectar a la Base de Datos";
    } else {
        echo "CONECTADO CON ÉXITO";
    }

    $ciclo_stmt = "";
    $grado_stmt = "";

    if (isset($_POST["ciclo"])) {
        $Ciclo = $_POST["ciclo"];
        $ciclo_stmt = "ciclo = '$Ciclo'";
        if ($Ciclo == "Secundaria") {
            $Grado = $_POST["secundaria"];
            if ($Grado == "Todos") {
                $grado_stmt = true;
            } else {
                $grado_stmt = "grado = '$Grado'";

            }
        } elseif ($Ciclo == "Primaria") {
            $Grado = $_POST["primaria"];
            if ($Grado == "Todos") {
                $grado_stmt = true;
            } else {
                $grado_stmt = "grado = '$Grado'";

            }
        } else {
            ($Grado = "Todos");
            $ciclo_stmt = true;
            $grado_stmt = true;
        }
        $Grado = lcfirst($Grado);

        $Orden = $_POST["orden"];
        $Orden == "nota" ? $Orden .= " DESC" : true;


        $sql = $conn->prepare("SELECT * from Estudiantes WHERE $ciclo_stmt and $grado_stmt ORDER BY " . $Orden);
        $sql->execute();

        $result = $sql->get_result();

        if ($result->num_rows > 0) {
    ?>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>Num.</th>
                <th scope='col'>APELLIDO</th>
                <th scope='col'>NOMBRE</th>
                <th scope='col'>GRADO</th>
                <th scope='col'>NOTA</th>
                <th scope='col'>ACCIÓN</th>
            </tr>
        </thead>
        <?php
            $numeral = 0;
            while ($row = $result->fetch_assoc()) {
                $numeral++; ?>
        <tr>
            <th scope='row'>
                <?= $numeral ?>
            </th>
            <td>
                <?= $row['apellido'] ?>
            </td>
            <td>
                <?= $row['nombre'] ?>
            </td>
            <td>
                <?= $row['grado'] ?>
            </td>
            <td>
                <?= $row['nota'] ?>
            </td>
            <td>
                <span class='btn-group'>
                    <form method='POST' action='modify.php'>
                        <button type='submit' class='btn btn-primary' name='modificar' value=<?= $row['id'] ?>>
                            <b>Modificar</b>
                        </button>
                    </form>
                    <form method='POST' action='eliminate.php'>
                        <button type='submit' class='btn btn-danger' name='eliminar' value=<?= $row['id'] ?>>
                            <b>X</b>
                        </button>
                    </form>
                </span>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    <?php
        }
    }

        ?>

</body>

</html>