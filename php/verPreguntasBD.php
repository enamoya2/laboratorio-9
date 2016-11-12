<?php
session_start();
include_once ("funcionalidades.php");

function imprimirPreguntas(){
	$mysqli = conect();
	$pregunta = mysqli_query($mysqli, "select * from pregunta");
	echo '<table border=1> <tr> <th> AUTOR </th> <th> COMPLEJIDAD </th> <th> ENUNCIADO </th></tr>';
	while ($row = mysqli_fetch_array( $pregunta )) {
		echo '<tr><td>' . $row['Email'] .'</td><td>' . $row['Complejidad'] . '</td> <td>' . $row['Pregunta'] . '</td></tr>';
	}
	echo '</table>';
	$pregunta->close();
	mysqli_close($mysqli);
	anadirAccion("ver_preguntas");
}
?>



<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>verPreguntasBD</title>
  </head>
  <body>
  <div id='page-wrap'>
	<?php include('../adds/header.php'); ?>
	<?php include('../adds/navegation.php'); ?>
    <section class="main" id="s1">
		<div>
			<?php imprimirPreguntas(); ?>
		</div>
    </section>
	<?php include('../adds/footer.php'); ?>
</div>
</body>
</html>
