<?php
session_start();
include_once ("funcionalidades.php");

function validateEmail($email){
	$re = '/^[a-zA-Z]{3,}\d{3}@ikasle\.ehu\.(es|eus)$/';
	return preg_match($re, $email);
}

function validateNombre($nombre){
	$re = '/^[A-Za-z]+(\s[A-Za-z]+)+$/';
	return preg_match($re, $nombre);
}

function validateTlf($tlf){
  $re = '/^[6-9][0-9]{8}$/';
	return preg_match($re, $tlf);
}

function validatePassword($password,$password2){
	if(strlen($password)<6)
		return false;
	return ($password == $password2);
}

function insertImage(){
	$target_dir = "../Images/";
	$target_dirdefault = "../Images/usuario.jpg";
	$target_file = $target_dir . basename($_FILES["foto"]["name"]);
	if($target_file == $target_dir){
		$target_file = $target_dirdefault;
	}
	$uploadOk = 1;
	$samefile = 0;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["foto"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		}
		else {
			echo "El archivo es una imagen.";
			$uploadOk = 0;
		}
	}

	if (file_exists($target_file)) {
			$samefile = 1;
	}

	if ($_FILES["foto"]["size"] > 500000) {
		echo "Tu fichero es demasiado grande.";
		$uploadOk = 0;
	}

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		echo "Solo estan permitidos los archivos de extension JPG, JPEG, PNG & GIF.";
		$uploadOk = 0;
	}


	if ($uploadOk == 0) {
		echo "Lo sentimos, tu imagen no se ha podido almacenar en la base de datos.";
		return;

	}
	else {
		if($samefile != 1){
			if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file))
				echo "Sorry, there was an error uploading your file.";
		}
		return $target_file;
	}

}


function registrarUser(){
	$mysqli = conect();
	$email=$_POST['email'];
	$nombre=$_POST['nombre'];
	$cod=$_POST['ticket'];
	$password=$_POST['password'];
	$password1=$_POST['password1'];
	$tlf=$_POST['tlf'];
	$especialidad=$_POST['especialidad'];
	if($especialidad=="otro"){
		$especialidad=$_POST['otraesp'];
	}
	$intereses=$_POST['intereses'];
	if(!isset($intereses)){
		$intereses = NULL;
	}

	if((validateEmail($email) == 0 ) || strcmp(validarEmail($email),"NO")==0){
		echo 'Fallo, <a href="registro.php">Volver a intentar</a>.';
		return;
	}

	if(validateNombre($nombre) == 0){
		echo 'Fallo, <a href="registro.php">Volver a intentar</a>.';
		return;
	}

	if(validateTlf($tlf) == 0){
		echo 'Fallo, <a href="registro.php">Volver a intentar</a>.';
		return;
	}

	if(validatePassword($password,$password1) == false || strcmp(comprobarPass($password,$cod),"INVALIDA")==0 || strcmp(comprobarPass($password,$cod),"USUARIO NO AUTORIZADO")==0){
		echo 'Fallo, <a href="registro.php">Volver a intentar</a>.';
		return;
	}
	$enc_pass = sha1($password);
	$path_img = insertImage();
	if($path_img != ""){

		$sql="INSERT INTO usuario(Nombre, Email, Password, Telefono, Especialidad, Intereses, Foto) VALUES ('$nombre','$email','$enc_pass',$tlf,'$especialidad','$intereses', '$path_img')";
		if (!mysqli_query($mysqli ,$sql)){
			echo "Error: " . mysqli_error($mysqli);
			return;
		}
		echo "Se ha incorporado el usuario a la base de datos.";
	}
	echo '<p> <a href="verUsuariosConFoto.php"> Ver registros</a>';

	mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>Inicio</title>
  </head>
  <body>
  <div id='page-wrap'>
	<?php include('../adds/header.php'); ?>
	<?php include('../adds/navegation.php'); ?>
    <section class="main" id="s1">
		<div>
			<?php
				if (!isset($_POST['email'])) {
					echo 'Fallo, <a href="registro.php">Volver a intentar</a>.';
				}
				else{
					registrarUser();
				}
			?>
		</div>
    </section>
	<?php include('../adds/footer.php'); ?>
</div>
</body>
</html>
