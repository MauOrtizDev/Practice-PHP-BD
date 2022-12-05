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
        <h2>Mostrar base de datos de Estudiantes:</h2>
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
        ?>
        <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
            <div class="row justify-content-center g-3">
                <div class="col-auto">
                    <label for="ciclo" class="form-label">Ciclo</label>
                    <?php
                    function verificarSeleccionado($name, $key)
                    {
                        $selected = (isset($_POST[$name]) && $_POST[$name] == $key) ? 'selected' : '';
                        return $selected;
                    }
                    ?>
                    <?php

                    $sql = "SELECT * from ciclos";
                    $result = $conn->query($sql);
                    $optionsCiclo = ['-1' => 'Todos'];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $optionsCiclo += [$row["ID"] => $row["nombre"]];
                        }
                    }
                    ;
                    ?>

                    <select class="form-select" name="ciclo" id="ciclo">
                        <?php foreach ($optionsCiclo as $key => $label) { ?>
                        <option value="<?= $key ?>" <?= verificarSeleccionado('ciclo', $key); ?>><?= $label ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-auto">
                    <label for="grado" class="form-label" id="labelGrado">Grado</label>

                    <?php
                    $sql = "SELECT * from grados";
                    $result = $conn->query($sql);
                    $optionsGrado = ['-1' => 'Todos'];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $optionsGrado += [$row["ID"] => $row["nombre"]];
                        }
                    }
                    ;
                    ?>

                    <select class="form-select" name="grado" id="grado" <?='style="display:inline;"' ?>>
                        <?php foreach ($optionsGrado as $key => $label) {
                            $sql = "SELECT nombre from ciclos where ID=(SELECT ID_ciclo from grados WHERE id=$key)";
                            $result = $conn->query($sql)->fetch_assoc();
                        ?>
                        <option class="<?= $result['nombre'] ?? "" ?>" value="<?= $key ?>" <?=
                            verificarSeleccionado('grado', $key); ?>><?= $label ?>

                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-auto">
                    <label for="orden" class="form-label" id="orden">Orden:</label>
                    <?php
                    $options = [
                        'ID' => 'Por defecto',
                        'apellido' => 'Por apellidos',
                        'nota' => 'Por promedio',
                    ];
                    ?>

                    <select class="form-select" name="orden" id="orden">
                        <?php foreach ($options as $key => $label) { ?>
                        <option value="<?= $key ?>" <?= verificarSeleccionado('orden', $key); ?>><?= $label ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <input type="submit" value="MOSTRAR">
            </div>
        </form>

        <?php

        if (isset($_POST["ciclo"])) {

            echo "<div style='position:absolute;top:0;right:0;background:yellow;'><pre class='text-start'>";
            var_dump($_POST);
            echo "</pre></div>";
            
            $Ciclo = intval($_POST["ciclo"]);
            $Grado = intval($_POST["grado"]);
            $Orden = $_POST['orden'];
            $Orden == "nota" ? $Orden .= " DESC" : true;

            if($Ciclo < 0){
                $sql = $conn->prepare("SELECT * from estudiantes ORDER BY $Orden");
            } elseif($Grado < 0){
                $sql = $conn->prepare("SELECT * from estudiantes where grado in (select id from grados where id_ciclo = $Ciclo) ORDER BY $Orden");
            } else {
                $sql = $conn->prepare("SELECT * from estudiantes where grado = $Grado ORDER BY $Orden");
            }
            ;
            
            $sql->execute();

            // // POR AQUI VOY
        
            // $ciclo_stmt = "ciclo = ";
            // $grado_stmt = "grado = ";
        
            // if($Ciclo = -1){
            //     $ciclo_stmt = true;
            //     $grado_stmt = true;
            // } elseif ($){
        
            // }
        
            // $ciclo_stmt = "ciclo = ".$Ciclo;
            // if ($Ciclo == "Secundaria") {
            //     $Grado = $_POST["secundaria"];
            //     if ($Grado == "Todos") {
            //         $grado_stmt = true;
            //     } else {
            //         $grado_stmt = "grado = '$Grado'";
        
            //     }
            // } elseif ($Ciclo == "Primaria") {
            //     $Grado = $_POST["primaria"];
            //     if ($Grado == "Todos") {
            //         $grado_stmt = true;
            //     } else {
            //         $grado_stmt = "grado = '$Grado'";
        
            //     }
            // } else {
            //     ($Grado = "Todos");
            //     $ciclo_stmt = true;
            //     $grado_stmt = true;
            // }
            // $Grado = lcfirst($Grado);
        
            // $Orden = $_POST["orden"];
            // $Orden == "nota" ? $Orden .= " DESC" : true;
        



            // $Ciclo = $_POST["ciclo"];
            // $Grado = $_POST["grado"];
            // // POR AQUI VOY
            // $ciclo_stmt = "ciclo = '$Ciclo'";
            // if ($Ciclo == "Secundaria") {
            //     $Grado = $_POST["secundaria"];
            //     if ($Grado == "Todos") {
            //         $grado_stmt = true;
            //     } else {
            //         $grado_stmt = "grado = '$Grado'";

            //     }
            // } elseif ($Ciclo == "Primaria") {
            //     $Grado = $_POST["primaria"];
            //     if ($Grado == "Todos") {
            //         $grado_stmt = true;
            //     } else {
            //         $grado_stmt = "grado = '$Grado'";

            //     }
            // } else {
            //     ($Grado = "Todos");
            //     $ciclo_stmt = true;
            //     $grado_stmt = true;
            // }
            // $Grado = lcfirst($Grado);

            // $Orden = $_POST["orden"];
            // $Orden == "nota" ? $Orden .= " DESC" : true;

            // $sql = $conn->prepare("SELECT * from Estudiantes WHERE $ciclo_stmt and $grado_stmt ORDER BY " . $Orden);
            // $sql->execute();

            $result = $sql->get_result();

            if ($result->num_rows > 0) { ?>
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
    </div>

</body>

</html>