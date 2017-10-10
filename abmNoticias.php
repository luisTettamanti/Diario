<?php
    require_once 'conexion.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    
    if (isset($_GET['borrar']) && isset($_POST['id']))
    {
        $id = get_post($conn, 'id');
        $query = "DELETE FROM Noticias WHERE id = '$id'";
        $result = $conn->query($query);
        if (!result) echo "Falló DELETE: . $query<br>" . $conn->error . "<br><br>";
    }

    if (isset($_GET['fecha']) &&
        isset($_GET['titulo']) &&
        isset($_GET['texto']) &&
        isset($_GET['autor']) &&
        isset($_GET['foto']) &&
        isset($_GET['idseccion']) &&
        isset($_GET['importancia']) &&
        isset($_GET['resumen']))
        {
            $fecha = get_post($conn, 'fecha');
            $titulo = get_post($conn, 'titulo');
            $texto = get_post($conn, 'texto');
            $autor = get_post($conn, 'autor');
            $foto = get_post($conn, 'foto');
            $idSeccion = get_post($conn, 'idseccion');
            $importancia = get_post($conn, 'importancia');
            $resumen = get_post($conn, 'resumen');
            //$query = "INSERT INTO Noticias ('fecha', 'titulo', 'texto', 'autor', 'foto', 'idseccion', 'importancia', 'resumen') VALUES ('$fecha', '$titulo', '$texto', '$autor', '$foto', '$idseccion', '$importancia', '$resumen')";
        
            $query = "INSERT INTO `noticias`(`fecha`, `titulo`, `texto`, `autor`, `foto`, `idseccion`, `importancia`, `resumen`) VALUES ('$fecha', '$titulo', '$texto', '$autor', '$foto', $idseccion, $importancia, '$resumen')";
        
            //$query      = "INSERT INTO clientes (`nombre`,`usuario`,`clave`,`correo`,`provincia`,`localidad`,`direccion`,`fijo`,`celular`,`cuitCuil`) VALUES" . "        ('$nombre','$usuario','$clave','$correo','$provincia','$localidad','$direccion','$fijo','$celular','$cuitCuil')";        

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
            <form action='abmNoticias.php' method='get'>
                id<br><input type='text' name='id'><br>
                fecha<br><input type='date' name='fecha'><br>
                titulo<br><input type='text' name='titulo'><br>
                texto<br><textarea name='texto'></textarea><br>
                autor<br><input type='text' name='autor'><br>
                foto<br><input type='text' name='foto'><br>
                idSeccion<br><input type='text' name='idSeccion'><br>
                importancia<br><input type='text' name='importancia'><br>
                resumen<br><textarea name='resumen'></textarea><br>
                <input type='submit' value='insertar'>
            </form>
        </body>
    </html>
    
_HTML;

    $query = 'SELECT * FROM Noticias';
    $result = $conn->query($query);
    if (!$result) die($conn->error);
    $rows = $result->num_rows;

    for ($i = 0; $i < $rows; ++$i) {
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_NUM);
        
echo <<<_HTML
        <br>
        id: $row[0]<br>
        fecha: $row[1]<br>
        titulo: $row[2]<br>
        texto: $row[3]<br>
        autor: $row[4]<br>
        foto: $row[5]<br>
        idseccion: $row[6]<br>
        importancia: $row[7]<br>
        resumen: $row[8]<br>
        <form action="abmNoticias.php" method="get">
            <input type="hidden" value="borrar" value="si">
            <input type="hidden" name="id" value="$row[0]">
            <input type="submit" value="Borrar noticia">
        </form>
_HTML;
        
    }

    $result->close();
    $conn->close();

    function get_post($conn, $var) {
        return $conn->real_escape_string($_GET[$var]);
    }

?>