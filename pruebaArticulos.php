<!DOCTYPE html>
<html lang="es">
<head>
    <!--<meta charset="utf-8">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title></title>
</head>

<body>
 
    <?php
        require_once 'conexion.php';
        $conn = new mysqli($hn,$un,$pw,$db);
        if ($conn->connect_error) die ($conn->connect_error);

        $query = 'SELECT * FROM Noticias INNER JOIN Secciones on secciones.id=noticias.idSeccion';
        $result = $conn->query($query);
        if (!$result) die ($conn->error);

        $rows = $result->num_rows;
        for ($j = 0; $j < $rows; $j++) {
            // Para recuperar datos una celda a la vez
            //$result->data_seek($j);
            //echo '<h3>' . $result->fetch_assoc()['titulo'] . '</h3>';
            //$result->data_seek($j);
            //echo $result->fetch_assoc()['resumen'] . '<br>';

            //Para recuperar datos una fila a la vez
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            echo "<div id='articulo' style='background-image: url(" . $row['foto'] . "); background-size: cover'>";
            echo "<div id='seccion' style='color:" . $row['color'] . "'>" . $row['nombre'] . '</div>';
            echo "<div id='titulo'>" . $row['titulo'] . '</div>';
            echo "<div id='texto'>" . $row['resumen'] . '</div>';
            //echo $row['texto'] . '<br>';
            echo '</div>';
        }

        $conn->close();
    ?>

</body>
</html><link rel="stylesheet" href="pruebaArticulos.css">