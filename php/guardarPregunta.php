<?php
	session_start();
	include_once ("funcionalidades.php");

	sleep(1);

	$comp=$_POST['complejidad'];
	$tematica=$_POST['tematica'];
	$pregunta=$_POST['pregunta'];
	$respuesta=$_POST['respuesta'];

	$tematica = htmlentities($tematica, ENT_QUOTES);
	$pregunta = htmlentities($pregunta, ENT_QUOTES);
	$respuesta = htmlentities($respuesta, ENT_QUOTES);
	$comp = htmlentities($comp, ENT_QUOTES);

	if (($tematica != "") && ($pregunta != "") && ($respuesta != "")){
		if (guardarPreguntaBD($comp, $tematica, $pregunta, $respuesta) && guardarPreguntaXML($comp, $tematica, $pregunta, $respuesta)){
			echo 'Pregunta almacenada';
			return;
		}
	}

	echo 'Error al almacenar la pregunta';


?>
