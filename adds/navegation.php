<?php include_once ("funcionalidades.php"); ?>
<nav class='main' id='n1' role='navigation'>

 <?php
 if(!isLogueado()){
  echo
  "<span><a href='../php/layout.php'>Inicio</a></span>
  <span><a href='../php/verPreguntasBD.php'>Preguntas</a></span>
  <span><a href='../php/creditos.php'>Creditos</a></span>";
 }

 elseif(isAlumno()){
  echo
  "<span><a href='../php/layout.php'>Inicio</a></span>
  <span><a href='../php/insPregunta.php'>Insertar Pregunta</a></span>
  <span><a href='../php/creditos.php'>Creditos</a></span>";
 }
 elseif(isProfesor()){
	 
  echo
  "<span><a href='../php/layout.php'>Inicio</a></span>
  <span><a href='../php/editarPregunta.php'>Gestionar Preguntas</a></span>
  <span><a href='../php/creditos.php'>Creditos</a></span>";
 }
 ?>

</nav>
