<?php // Modifica Sección 
    
echo <<<HTMLBLOCK
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Secciones - Modificar</title>
    </head>

    <body>
    <h3>Secciones - Modificar</h3>
HTMLBLOCK;

require_once 'conexion.php';
$conn=new mysqli($hn,$un,$pw,$db);
if ($conn->connect_error) die($conn->connect_error);

$id = $_GET['id'];
$query="SELECT * FROM secciones WHERE id='$id'";
$result=$conn->query($query);
if (!$result) echo "RECUPERAR falló: $query<br>" . $conn->error . "<br><br>";

$result->data_seek(0);
$row=$result->fetch_array(MYSQL_ASSOC);

$id         = $row["id"];
$nombre     = $row["nombre"];
$imagen     = $row["imagen"];
$color      = $row["color"];

echo <<<HTMLBLOCK
<form action="Secciones.php" method="post"><pre>
Id         <input type="text" name="id" value=$id>
Nombre     <input type="text" name="nombre" value="$nombre">
Imagen     <input type="text" name="imagen" value="$imagen">
Color      <input type="text" name="color" value="$color">
           <input type="hidden" name="modificar" value="yes">
           <input type="submit" value="modificar">
</pre></form>
</body>
</html>
HTMLBLOCK;

function get_post($conn,$var)
{
    return $conn->real_escape_string($_POST[$var]);
}

?>