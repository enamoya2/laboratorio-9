<?php 
include_once ("../php/funcionalidades.php");


$pass=$_POST['pass'];
$cod=$_POST['cod'];
if(!isset($pass) || !isset($cod) ){
	echo "ERROR";
	return;
}
/*$soapclient = new nusoap_client('http://localhost/ProyectoSW/soapServicios/comprobarContrasena.php?wsdl',false);
	//Llamamos la función que habíamos implementado en el Web Service
	//e imprimimos lo que nos devuelve
	$result = $soapclient->call('comprobarContrasena', array('pass'=>$pass));
	print_r($result);*/
	print_r(comprobarPass($pass, $cod))
?>