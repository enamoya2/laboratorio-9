<?php 
include_once ("../php/funcionalidades.php");


$email=$_POST['email'];
if(!isset($email)){
	echo "NO";
	return;
}

print_r(validarEmail($email));
?>