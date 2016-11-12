<?php
session_start();
include_once ("funcionalidades.php");

function obtenerPreg(){
	$mysqli = conect();
	$consulta = 'select * from pregunta';
	$resul = mysqli_query($mysqli,$consulta);
	mysqli_close($mysqli);
	return $resul;
}

function crearFormularioPregunta(){
	echo
		'<table class="tabla" BORDER=0>
            <tr>
              <td>Selecciona una pregunta</td>
              <td>
                <select id="selectPreg" name="selectPreg" onChange="mostrarPreguntaSeleccionada()">
								<option value="0" selected="selected"></option>';
								$resul = obtenerPreg();
								while($lista=mysqli_fetch_assoc($resul)){
									echo '<option value='.$lista["Numero"].'>'.$lista["Pregunta"].'</option>';
								}
            echo '</select>
			  </td>
			</tr>
			</table>
			</br>
			<div id="resp"></div>
			</br>
			<div id="resultado"></div>';
}
?>





<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>Editar Pregunta</title>
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
					if(isProfesor()){
							crearFormularioPregunta();
					}
					else{
						echo "Para acceder aqui se debes ser un profesor.";
					}
				?>
			</div>
		</section>
		<?php include('../adds/footer.php'); ?>
	</div>
</body>
</html>

<script>

function mostrarPreguntaSeleccionada(){
	$('#resultado').html("");
	var pregunta = $("#selectPreg").val();
	if(pregunta == 0){
		$("#datos_preg").remove();
		$("#bot_editar").remove();
		return;		
	}


	$.ajax({
		url: 'datosPreguntaSeleccionada.php',
		type: "POST",
		data: "pregunta="+pregunta,
		beforeSend:function(){
			$('#resp').html('<img src="../Images/loading.gif" width="100px"/>');
		},
		success:function(datos){
				$('#resp').html(datos);
		},
		error:function(){
			$('#resp').html("Error Inesperado");
		}
	});
}

function editarPregunta(){
	if($("#tematica").val()=="" && $("#pregunta").val()=="" && $("#respuesta").val()=="" && $("#complejidad").val()=="")
		return;
	var re = /^[0-5]$/;
	if($("#complejidad").val()!="" && !re.test($("#complejidad").val())){
		alert("La complejidad es 0 -> 5");
		$("#complejidad").val("");
		return;
	}
	if($("#tematica").val()=="")
		var tematica=$("#tematica").attr('placeholder');
	else
		var tematica=$("#tematica").val();
	
	if($("#pregunta").val()=="")
		var pregunta=$("#pregunta").attr('placeholder');
	else
		var pregunta=$("#pregunta").val();
	
	if($("#respuesta").val()=="")
		var respuesta=$("#respuesta").attr('placeholder');
	else
		var respuesta=$("#respuesta").val();
	
	if($("#complejidad").val()=="")
		var complejidad=$("#complejidad").attr('placeholder');
	else
		var complejidad=$("#complejidad").val();
	
	var seleccionado = $("#selectPreg").val();
	
	var parametros = {
			"numero" : seleccionado, 
			"tematica" : tematica,
			"pregunta" : pregunta,
			"respuesta" : respuesta,
			"complejidad" : complejidad
	};
	$.ajax({
		url: 'editPregunta.php',
		type: "POST",
		data: parametros,
		beforeSend:function(){
			$('#resultado').html('<img src="../Images/loading.gif" width="100px"/>');
		},
		success:function(datos){
				$('#resultado').html(datos);
				$('#selectPreg option[value='+seleccionado+']').remove();
				$("#selectPreg").append('<option value='+seleccionado+'>'+pregunta+'</option>');
				$("#datos_preg").remove();
				$("#bot_editar").remove();
		},
		error:function(){
			$('#resultado').html("Error Inesperado");
		}
	});
}

</script>
