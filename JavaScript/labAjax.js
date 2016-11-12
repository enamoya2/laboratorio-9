

function insertarPregunta(){
	xmlhttp = new XMLHttpRequest();
	var comp = document.getElementById("complejidad").value;
	var tematica = document.getElementById("tematica").value;
	var pregunta = document.getElementById("pregunta").value;
	var respuesta = document.getElementById("respuesta").value;

	xmlhttp.onreadystatechange = function(){
		document.getElementById("resp").innerHTML = '<img src="../Images/loading.gif" width="100px"/>';
		if (xmlhttp.readyState == 4){
			if (xmlhttp.status == 200){
				document.getElementById("resp").innerHTML = xmlhttp.responseText;
			} else {
				 document.getElementById("resp").innerHTML = "Error al almacenar la pregunta";
			}
		}
	}

	xmlhttp.open("POST","guardarPregunta.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("complejidad="+comp+"&tematica="+tematica+"&pregunta="+pregunta+"&respuesta="+respuesta);
}


function verTodasPreguntas(){
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function(){
		document.getElementById("resp").innerHTML = '<img src="../Images/loading.gif" width="100px"/>';
		if (xmlhttp.readyState == 4){
			if (xmlhttp.status == 200){
				document.getElementById("resp").innerHTML = xmlhttp.responseText;
			} else {
				 document.getElementById("resp").innerHTML = "Error al mostrar las preguntas";
			}
		}
	}

	xmlhttp.open("POST","imprimirPreguntasXML.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}

function verMisPreguntas(){
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function(){
		document.getElementById("resp").innerHTML = '<img src="../Images/loading.gif" width="100px"/>';
		if (xmlhttp.readyState == 4){
			if (xmlhttp.status == 200){
				document.getElementById("resp").innerHTML = xmlhttp.responseText;
			} else {
				document.getElementById("resp").innerHTML = "Error al mostrar las preguntas";
			}
		}
	}

	xmlhttp.open("POST","imprimirPreguntasBD.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}

setInterval(numPreguntas, 5000);

function numPreguntas(){
	$.ajax({
		url: '../php/numeroPreguntas.php',
		type: "POST",
		//beforeSend:function(){$("#numpre").html('<img src="../Images/loading.gif" width="50px"/>')},
		success:function(response){$("#numpre").html(response)},
		error:function(){$('#numpre').html('<p><strong>El servidor parece que no responde</p>')}
	});
}
