<?php
session_start();
include_once ("funcionalidades.php");

function crearFormLogin(){
	echo
		'<div id="loginForm">
		<form action="login.php" method="post" class="login">
			<h2> Identificacion de Usuario </h2>
			<div>Username<input name="email" type="text" required></div>
			<div>Password<input name="pass" type="password" required></div>
			<div><input id="login" name="login" type="submit" value="login"></div>
		</form>
			<button type="button" onclick="mostrarForm()"> Recuperar contrasena </button>
		</div>';
}

function crearFormRecuperar(){
	echo
		'<div id="recuperarForm" style="display: none">
			<h2> Recuperar contraseña </h2>
			<div>Username<input name="emailR" id="emailR" type="text" required></div>
			<div><input id="recuperar" name="recuperar" type="submit" value="Recuperar" onclick=peticionPassNueva()></div>
			<button type="button" onclick="mostrarFormL()"> Logear </button>
			<div id="respuesta"></div>
		</div>';
}


function verificarLogin($email, $pass){
	$mysqli = conect();
	$usuarios = mysqli_query($mysqli, "select * from usuario where Email='$email' and Password='$pass'");
	$cont= mysqli_num_rows($usuarios);
	if($cont==0){
		echo '<p>Los datos no son correctos, intentalo de nuevo.</p>';
		$usuarios = mysqli_query($mysqli, "select * from usuario where Email='$email'");
		$cont= mysqli_num_rows($usuarios);
		if($cont!=0 && $email != "web000@ehu.es"){
			$row = mysqli_fetch_assoc( $usuarios );
			$ins = $row['NumIntentos']+1;
			echo "<p>Llevas $ins intentos</p>";
			$sql="UPDATE usuario SET NumIntentos=$ins WHERE Email='$email'";
			if (!mysqli_query($mysqli ,$sql)){
				echo "Error: " . mysqli_error($mysqli);
				return;
			}
		}
		echo '</br>';
		crearFormLogin();
	}
	else{
		$row = mysqli_fetch_assoc( $usuarios );
		$intentos = $row['NumIntentos'];
		if($intentos >= 3){
			echo "La cuenta se ha bloqueado por motivos de seguridad";
		}
		else{
			echo "Bienvenido,". $row['Nombre'];
			//session_start();
			date_default_timezone_set("Europe/Madrid");
			$sql="UPDATE usuario SET NumIntentos=0 WHERE Email='$email'";
			if (!mysqli_query($mysqli ,$sql)){
				echo "Error: " . mysqli_error($mysqli);
				return;
			}
			$date = date('Y-m-d H:i:s');
			$_SESSION["date"] = $date;
			$_SESSION["email"] = $row['Email'];
			$_SESSION["nombre"] = $row['Nombre'];
			$_SESSION["rol"] = $row['Rol'];
			$_SESSION["foto"] = $row['Foto'];
			$sql="INSERT INTO conexiones(Email, Hora) VALUES ('$email','$date')";
			if (!mysqli_query($mysqli ,$sql)){
				echo "Error: " . mysqli_error($mysqli);
				return;
			}
			$resultado = mysqli_query($mysqli, "select * from conexiones where Email='$email' and Hora='$date'");
			$conexion = mysqli_fetch_assoc( $resultado );
			$_SESSION["conexion"] = $conexion['Identificador'];
			if($_SESSION["rol"]=="Alumno")
				header("location:insPregunta.php");
			if($_SESSION["rol"]=="Profesor")
				header("location:editarPregunta.php");
		}
}
	mysqli_close($mysqli);
}

?>

<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>Login</title>
	<script>
		function mostrarForm(){
			$('#recuperarForm').show();
			$('#loginForm').hide();
		}

		function mostrarFormL(){
			$('#recuperarForm').hide();
			$('#loginForm').show();
		}
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  </head>
  <body>
  <div id='page-wrap'>
	<?php include('../adds/header.php'); ?>
	<?php include('../adds/navegation.php'); ?>
    <section class="main" id="s1">
		<div>
		<?php
			if(!isLogueado()){
				if(isset($_POST['email']) && isset($_POST['pass'])){
					$email = $_POST['email'];
					$pass = sha1($_POST['pass']);
					verificarLogin($email, $pass);
				}
				else{
					crearFormLogin();
					crearFormRecuperar();
				}
			}
			else{
				echo 'Ya estas logueado '.$_SESSION["nombre"].'.';
			}
		?>

		</div>
    </section>
	<?php include('../adds/footer.php'); ?>
</div>
</body>
</html>

<script>
function peticionPassNueva(){
	if($("#emailR").val()=="")
		return;

		$.ajax({
		data: "emailR="+$("#emailR").val(),
		url: 'recuperarContrasena.php',
		type: "POST",
		success: function (response) {
			$("#respuesta").html(response);
		},
		error:function(){$('#respuesta').html('Error Inesperado')}
		});
}


</script>
