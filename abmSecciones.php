<?php
    require_once 'conexion.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    
    if (isset($_POST['borrar']) && isset($_POST['id']))
    {
        $id = get_post($conn, 'id');
        $query = "DELETE FROM secciones WHERE id = '$id'";
        $result = $conn->query($query);
        if (!$result) echo "Falló DELETE: . $query<br>" . $conn->error . "<br><br>";
    }

    if (isset($_POST['nombre']) &&
        isset($_POST['imagen']) &&
        isset($_POST['color']))
        {
            //$nombre = get_post($conn, 'nombre');
            //$imagen = get_post($conn, 'imagen');
            //$color = get_post($conn, 'color');
        
            $nombre = $_POST['nombre'];
            $imagen = $_POST['imagen'];
            $color = $_POST['color'];
            
            $query = "INSERT INTO secciones (nombre, imagen, color) VALUES ('$nombre', '$imagen', '$color')";

            $result = $conn->query($query);
            if (!$result) echo "Falló AGREGAR: . $query<br> . $conn->error . <br><br>";     
        }

echo <<<_HTML

<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="iso-8859-1">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title></title>
        </head>

        <body>
            <form action='abmSecciones.php' method='post'>
                id<br><input type='text' name='id'><br>
                nombre<br><input type='text' name='nombre'><br>
                imagen<br><input type='text' name='imagen'><br>
                color<br><input type='text' name='color'><br>
                <input type='submit' value='insertar'>
            </form>
            <br><br>
            <table border=1>   
_HTML;

    $query = 'SELECT * FROM secciones';
    $result = $conn->query($query);
    if (!$result) die($conn->error);
    $rows = $result->num_rows;

    for ($i = 0; $i < $rows; ++$i) {
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_NUM);
        
echo <<<_HTML
            <tr>
                <td><a href="abmSecciones.php">$row[0]<a></td>
                <td>$row[1]</td>
                <td>$row[2]</td>
                <td style="background-color: $row[3]">$row[3]</td>
                <td>
                <form action="abmSecciones.php" method="post">
                    <input type="hidden" name="borrar" value="yes">
                    <input type="hidden" name="id" value="$row[0]">
                    <input type="submit" value="borrar">
                </form>
                </td>
            </tr>
_HTML;
        
    }

    echo '</table>';
    echo '</body>';
    echo '</html>';

    $result->close();
    $conn->close();

    function get_post($conn, $var) {
        return $conn->real_escape_string($_POST[$var]);
    }

?>