<?php
	session_start();
	include_once ("funcionalidades.php");

	sleep(1);

	$comp=$_POST['complejidad'];
	$tematica=$_POST['tematica'];
	$pregunta=$_POST['pregunta'];
	$respuesta=$_POST['respuesta'];


	if (($tematica != "") && ($pregunta != "") && ($respuesta != "")){
		if (guardarPreguntaBD($comp, $tematica, $pregunta, $respuesta) && guardarPreguntaXML($comp, $tematica, $pregunta, $respuesta)){
			echo 'Pregunta almacenada';
			return;
		}
	}

	echo 'Error al almacenar la pregunta';


?>
