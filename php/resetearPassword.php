<<?php
include_once ("funcionalidades.php");

function comprobarEnlace(){
	$link = $_GET['link'];
  $email = $_GET['email'];
  if(!isset($link) || !isset($email)){
    echo '<p>Enlace no valido</p>';
    return false;
  }
  $mysqli=conect();
  $resultado = mysqli_query($mysqli, "select * from link_contrasenas where Email='$email'");
  $cont= mysqli_num_rows($resultado);
  if($cont==0){
    echo '<p>Enlace no valido</p>';
    mysqli_close($mysqli);
    return false;
  }
  mysqli_close($mysqli);
  return true;
}

function generarForm(){
	$link = $_GET['link'];
  $email = $_GET['email'];
  echo '<form action="resetearPass.php" method="post" onSubmit="return validatePassword()">
        <h2>Resetear contraseña </h2>
        <label for="password"> Nueva contraseña </label>
        <input type="password"  name="password"  id="password" onchange="validarPassword()" required>
		<div id="passVal" style="display: none"></div>
        <label for="password2"> Confirmar contraseña </label>
        <input type="password"  name="password1"  id="password1" required><br/>
       <input type="hidden" name="link" value="'.$link.'">
       <input type="hidden" name="email" value="'.$email.'">
        <input type="submit" id="botsubmit" value="Cambiar contraseña" disabled=true >';
}


?>

 <!DOCTYPE html>
 <html>
   <head>
 	<?php include('../adds/StyleAndMeta.php'); ?>
 	<title>Login</title>
  <script type="text/javascript" src="../JavaScript/Validaciones.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="../JavaScript/soapAjax.js"></script>
   </head>
   <body>
   <div id='page-wrap'>
 	<?php include('../adds/header.php'); ?>
 	<?php include('../adds/navegation.php'); ?>
     <section class="main" id="s1">
 		<div>
 		<?php
      if (comprobarEnlace()){
        generarForm();
      }
 		?>
 		</div>
     </section>
 	<?php include('../adds/footer.php'); ?>
 </div>
 </body>
 </html>


 <script>
	function validarPassword(){
	var input = document.getElementById("password");
	if($('#password').val()== ""){
		$('#password').css('background-color', 'white');
		$('#passVal').html("NO");
		input.setCustomValidity('');
		return;
	}
		var parametros = {
			"pass" : $('#password').val(),
			"cod" : "2727"
		};
		$.ajax({
		data: parametros,
		url: '../AjaxPhp/comprobarPass.php',
		type: "POST",
		success: function (response) {
						if(response == "VALIDA"){
							$('#password').css('background-color', '#66ff33');
							input.setCustomValidity('');
						}
						else if(response == "USUARIO NO AUTORIZADO"){
							$('#password').css('background-color', '#ff00ff');
						}
						else{
							$('#password').css('background-color', 'red');
							input.setCustomValidity('Pass incorrecto');
						}
						$('#passVal').html(response);
						activarBottonS();
		},
				error:function(){$('#passVal').html('Error')}
			});
}

function activarBottonS(){
	if(($('#passVal').html() == "VALIDA"))
		$('#botsubmit').prop( "disabled", false );
	else
		$('#botsubmit').prop( "disabled", true );
}


 </script>
