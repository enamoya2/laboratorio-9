<?php
	session_start();
	include_once ("funcionalidades.php");

	sleep(1);
	
	$mysqli = conect();
	$mail=$_SESSION["email"];
	$totalPregunta = mysqli_query($mysqli, "select * from pregunta");
	$sql= "select * from pregunta where Email=". $_SESSION["email"];
	$misPregunta = mysqli_query($mysqli, "select * from pregunta where Email= '$mail'");
	
	$contTotal= mysqli_num_rows($totalPregunta);
	$contMio= mysqli_num_rows($misPregunta);
	
	echo "Mis preguntas / Todas las preguntas:" . $contMio . " / " . $contTotal;

	mysqli_close($mysqli);
?>