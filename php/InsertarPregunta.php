<?php
session_start();
include_once ("funcionalidades.php");

function validarComplejidad($comp){
	$re = '/^[1-5]$/';
	return preg_match($re, $comp);
}
function guardarPreguntaBD(){
	$mysqli = conect();
	$comp=$_POST['complejidad'];
	$email=$_SESSION["email"];
	$tematica=$_POST['tematica'];
	$pregunta=$_POST['pregunta'];
	$respuesta=$_POST['respuesta'];

	if(!validarComplejidad($comp)){
		$comp=0;
	}
	$sql="INSERT INTO pregunta(Email,  Tematica, Pregunta, Respuesta, Complejidad) VALUES ('$email', '$tematica', '$pregunta','$respuesta',$comp)";
	if (!mysqli_query($mysqli ,$sql)){
		echo "Error: " . mysqli_error($mysqli);
		return;
	}
	else{
		echo '<p>Pregunta almacenada, si desea almacenar otra pregunta <a href="InsertarPregunta.php">pulsa aqui</a>.</p>';
		echo '<br/><a href="verPreguntasBD.php"> Ver Preguntas BD </a>';
	}

	mysqli_close($mysqli);
	anadirAccion("insertar_pregunta");
}

function guardarPreguntaXML(){
	$comp=$_POST['complejidad'];
	$tematica=$_POST['tematica'];
	$pregunta=$_POST['pregunta'];
	$respuesta=$_POST['respuesta'];
	
	$xml = simplexml_load_file('../xml/preguntas.xml');

	$pregunt = $xml->addChild('assessmentItem');
	
	if($comp==0)
		$pregunt->addAttribute('complexity', 'No tiene Complejidad');
	else
		$pregunt->addAttribute('complexity', $comp);
	$pregunt->addAttribute('subject', $tematica);
	
	$body = $pregunt->addChild('itemBody');
	$body->addChild('p', $pregunta);
	$respu = $pregunt->addChild('correctResponse');
	$respu->addChild('value',$respuesta);
	
	$resultado = $xml->asXML('../xml/preguntas.xml');
	if($resultado == 1){
		echo '<p>Pregunta insertada correctamente en preguntas.xml</p>';
		echo '<br/><a href="verPreguntasXML.php"> Ver Preguntas XML </a>';
	}
	else
		echo '</p> La pregunta no se ha insertado en el fichero xml correspondiente.</p>';
}

function crearFormularioPregunta(){
	echo
		'<form id="inspregunta" method="post" action="InsertarPregunta.php">
					<table BORDER=0 align="center">
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
							<td colspan=2><input type="submit" value="Enviar"></td>
						</tr>
					</table>
				</form>';
}
?>





<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>Insertar Pregunta</title>
  </head>
  <body>
	<div id='page-wrap'>
		<?php include('../adds/header.php'); ?>
		<?php include('../adds/navegation.php'); ?>
		<section class="main" id="s1">
			<div>
				<?php
					if(isLogueado()){
						if(isset($_POST['respuesta']) && isset($_POST['pregunta'])){
							guardarPreguntaBD();
							guardarPreguntaXML();
						}
						else{
							crearFormularioPregunta();
						}
					}
					else{
						echo "Para acceder aqui se debe estar registrado.";
					}
				?>
			</div>
		</section>
		<?php include('../adds/footer.php'); ?>
	</div>
</body>
</html>
