<?php
include_once ("funcionalidades.php");

$num = $_POST['pregunta'];
if(!isset($num)){
	echo "ERROR";
	return;
}
$mysqli = conect();
$pregunta = mysqli_query($mysqli, "select * from pregunta where Numero='$num'");
$row = mysqli_fetch_array( $pregunta );

echo '<table id="datos_preg" class="tabla" BORDER=0>
	<tr>
		<td>Autor </td>
		<td> <p>'. $row['Email'] . '</p></td>
	</tr>
	<tr>
		<td>Tematica (*)</td>
		<td> <input type="text" name="tematica" id="tematica" placeholder="' . $row['Tematica'] . '"></td>
	</tr>
	<tr>
		<td>Pregunta (*)</td>
		<td> <input type="text" name="pregunta" id="pregunta" placeholder="' . $row['Pregunta'] . '"></td>
	</tr>
	<tr>
		<td>Respuesta (*)</td>
		<td><input type="text" name="respuesta" id="respuesta" placeholder="' . $row['Respuesta'] . '"></td>
	</tr>
	<tr>
		<td>Complejidad</td>
		<td><input type="text" name="complejidad" id="complejidad" placeholder="' . $row['Complejidad'] . '"></td>
	</tr>
	</table>
	</br>
	<input id="bot_editar" type="button" value="Guardar Cambios" onclick="editarPregunta()">';
	
	
	mysqli_close($mysqli);
	
?>