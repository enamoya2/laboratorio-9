<?php
session_start();
include_once ("funcionalidades.php");

function crearFormularioPregunta(){
	echo
		'
		<div id=numpre></div>
		</br>
		<form id="inspregunta">
					<table class="tabla" BORDER=0>
						<tr>
							<td>Tematica (*)</td>
							<td> <input type="text" name="tematica" id="tematica" required></td>
						</tr>
						<tr>
							<td>Pregunta (*)</td>
							<td> <input type="text" name="pregunta" id="pregunta" required></td>
						</tr>
						<tr>
							<td>Respuesta (*)</td>
							<td><input type="text" name="respuesta" id="respuesta" required></td>
						</tr>
						<tr>
							<td>Complejidad</td>
							<td>
								<select id="complejidad" name="complejidad">
									<option value="0" selected="selected"></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><input type="button" value="Enviar" onclick="insertarPregunta()"></td>
							<td><input type="button" value="Todas las Preguntas" onclick="verTodasPreguntas()"></td>
							<td><input type="button" value="Mis Preguntas" onclick="verMisPreguntas()"></td>
						</tr>
					</table>
				</form>
				</br>
				<div id="resp">
				</div>

		';
}
?>





<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>Insertar Pregunta</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="../JavaScript/labAjax.js"></script>
  </head>
  <body>
	<div id='page-wrap'>
		<?php include('../adds/header.php'); ?>
		<?php include('../adds/navegation.php'); ?>
		<section class="main" id="s1">
			<div>
				<?php
					if(isAlumno()){
							crearFormularioPregunta();
					}
					else{
						echo "Para acceder aqui se debes ser un alumno.";
					}
				?>
			</div>
		</section>
		<?php include('../adds/footer.php'); ?>
	</div>
</body>
</html>
