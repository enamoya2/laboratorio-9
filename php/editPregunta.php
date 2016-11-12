<?php
include_once ("funcionalidades.php");
$mysqli = conect();

$num = $_POST['numero'];
$tematica = $_POST['tematica'];
$pregunta = $_POST['pregunta'];
$respuesta = $_POST['respuesta'];
$complejidad = $_POST['complejidad'];
if(!isset($num) || !isset($tematica) || !isset($pregunta) || !isset($respuesta) || !isset($complejidad)){
	echo "ERROR";
	return;
}

$sql="UPDATE pregunta SET Tematica='$tematica', Pregunta='$pregunta', Respuesta='$respuesta', Complejidad='$complejidad' WHERE Numero='$num'";

if (!mysqli_query($mysqli ,$sql)){
				echo "Error: " . mysqli_error($mysqli);
				return;
}
echo "Pregunta Almacenada Correctamente";
mysqli_close($mysqli);
?>