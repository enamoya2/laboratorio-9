<?php
include_once ("funcionalidades.php");


function comprobar(){
	$pass1 = $_POST['password'];
	$pass2 = $_POST['password1'];
	$link = $_POST['link'];
	$email = $_POST['email'];
	if(!isset($pass1) || !isset($pass2) || !isset($link) || !isset($email) || ($pass1 != $pass2)){
		echo '<p> Error</p>';
		return false;
	}
	return true;
}

function resetPass(){
	$mysqli=conect();
	$pass1 = $_POST['password'];
	$pass2 = $_POST['password1'];
	$link = $_POST['link'];
	$email = $_POST['email'];
	$resultado = mysqli_query($mysqli, "select * from link_contrasenas where Email='$email' and Link='$link'");
	$cont= mysqli_num_rows($resultado);
	if($cont==0){
		echo '<p>Enlace no valido</p>';
		mysqli_close($mysqli);
		return;
	}
	$pass1=sha1($pass1);
	$sql="UPDATE usuario SET Password='$pass1' WHERE Email='$email'";
  	if (!mysqli_query($mysqli ,$sql)){
  		echo "Error: " . mysqli_error($mysqli);
  		return ;
  	}

	$sql="DELETE FROM link_contrasenas WHERE Email='$email'";
	if (!mysqli_query($mysqli ,$sql)){
		echo "Error: " . mysqli_error($mysqli);
		return;
	}
	mysqli_close($mysqli);
	echo '<p> Actualizacion del password satisfactorio </p>';
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
      if (comprobar()){
        resetPass();
      }
 		?>
 		</div>
     </section>
 	<?php include('../adds/footer.php'); ?>
 </div>
 </body>
 </html>
