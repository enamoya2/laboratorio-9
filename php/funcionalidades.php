<?php
require_once('../nusoap/lib/nusoap.php');
require_once('../nusoap/lib/class.wsdlcache.php');

function conect(){
	$mysqli =mysqli_connect("mysql.hostinger.es","u875296919_root","rootena","u875296919_usu") or die(mysql_error()); //hostinger
	//$mysqli = mysqli_connect("localhost", "root", "", "quiz");  //local
	if (!$mysqli) {
		echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
		exit;
	}
	return $mysqli;
}

function isLogueado(){ //Ver si el usuario es anonimo
 return isset($_SESSION["email"]);
}

function isAlumno(){
	//Ver si el usuario es alumno
	return isset($_SESSION["email"]) && $_SESSION["rol"]=="Alumno";
}

function isProfesor(){
	return isset($_SESSION["email"]) && $_SESSION["rol"]=="Profesor";

}

function mensajeHeader(){
	if(!isLogueado())
		echo 'Bienvenido, Anonimo.       <img src="../Images/usuario.jpg" width="40px" height="40px"/>';
	else
		echo 'Bienvenido, '.$_SESSION["nombre"]. '       <img src="'.$_SESSION["foto"].'" width="40px" height="40px"/>';
}

function GetUserIP() {
    if (isset($_SERVER)) {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];

        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];
        return $_SERVER["REMOTE_ADDR"];
    }
    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');

    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');
    return getenv('REMOTE_ADDR');
}

function anadirAccion($tipo){
	date_default_timezone_set("Europe/Madrid");
	$date = date('Y-m-d H:i:s');
	$ip = GetUserIP();
	$mysqli = conect();

	if (isLogueado()){
		$email = $_SESSION["email"];
		$conexion = $_SESSION["conexion"];
		$sql="INSERT INTO acciones(Id_Conexion, Email, Tipo, Hora, IP) VALUES ($conexion, '$email','$tipo', '$date', '$ip')";
	}else{
		$sql="INSERT INTO acciones(Tipo, Hora, IP) VALUES ('$tipo', '$date', '$ip')";
	}

	if (!mysqli_query($mysqli ,$sql)){
		echo "Error: " . mysqli_error($mysqli);
		return;
	}
	mysqli_close($mysqli);
}

function validarComplejidad($comp){
	$re = '/^[1-5]$/';
	return preg_match($re, $comp);
}

function guardarPreguntaXML($comp, $tematica, $pregunta, $respuesta){
	//$comp=$_POST['complejidad'];
	//$tematica=$_POST['tematica'];
	//$pregunta=$_POST['pregunta'];
	//$respuesta=$_POST['respuesta'];

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
		//echo '<p>Pregunta insertada correctamente en preguntas.xml</p>';
		//echo '<br/><a href="verPreguntasXML.php"> Ver Preguntas XML </a>';
		return true;
	}
	else
		return false;
		//echo '</p> La pregunta no se ha insertado en el fichero xml correspondiente.</p>';
}

function guardarPreguntaBD($comp, $tematica, $pregunta, $respuesta){
	$mysqli = conect();
	//$comp=$_POST['complejidad'];
	$email=$_SESSION["email"];
	//$tematica=$_POST['tematica'];
	//$pregunta=$_POST['pregunta'];
	//$respuesta=$_POST['respuesta'];

	if(!validarComplejidad($comp)){
		$comp=0;
	}
	$sql="INSERT INTO pregunta(Email,  Tematica, Pregunta, Respuesta, Complejidad) VALUES ('$email', '$tematica', '$pregunta','$respuesta',$comp)";
	if (!mysqli_query($mysqli ,$sql)){
		echo "Error: " . mysqli_error($mysqli);
		return false;
	}
	else{
		anadirAccion("insertar_pregunta");
		return true;
		//echo '<p>Pregunta almacenada, si desea almacenar otra pregunta <a href="InsertarPregunta.php">pulsa aqui</a>.</p>';
		//echo '<br/><a href="verPreguntasBD.php"> Ver Preguntas BD </a>';
	}

	mysqli_close($mysqli);
}

function imprimirPreguntasXML(){
	$xml = simplexml_load_file('../xml/preguntas.xml');
	echo '<table class="tabla" border=1> <tr> <th> TEMATICA </th> <th> COMPLEJIDAD </th> <th> ENUNCIADO </th></tr>';
	foreach($xml->children() as $pregunta){
		echo '<tr> <th>' . $pregunta['subject'] . '</th> <th>'. $pregunta['complexity'] . '</th>';
		foreach($pregunta->children() as $child){
			if($child->getName() == 'itemBody'){
				echo '<th>' . $child->p . '</th>';
			}
		}
		echo '</tr>';
	}
	echo '</table>';
	anadirAccion("ver_preguntas");
}

function imprimirPreguntasBD($email){
	$mysqli = conect();
	$pregunta = mysqli_query($mysqli, "select * from pregunta where Email='$email'");
	echo '<table class="tabla" border=1> <tr> <th> AUTOR </th> <th> TEMATICA </th> <th> COMPLEJIDAD </th> <th> ENUNCIADO </th></tr>';
	while ($row = mysqli_fetch_array( $pregunta )) {
		echo '<tr><td>' . $row['Email'] .'</td><td>' . $row['Tematica'] .'</td><td>' . $row['Complejidad'] . '</td> <td>' . $row['Pregunta'] . '</td></tr>';
	}
	echo '</table>';
	$pregunta->close();
	mysqli_close($mysqli);
	anadirAccion("ver_preguntas");
}

function validarEmail($email){
	//creamos el objeto de tipo soapclient.
	//donde se encuentra el servicio SOAP que vamos a utilizar.
	$soapclient = new nusoap_client('http://cursodssw.hol.es/comprobarmatricula.php?wsdl',false);
	//Llamamos la función que habíamos implementado en el Web Service
	//e imprimimos lo que nos devuelve
	$result = $soapclient->call('comprobar', array('x'=>$email));
	return $result;
}

function comprobarPass($pass, $cod){
	//creamos el objeto de tipo soapclient.
	//donde se encuentra el servicio SOAP que vamos a utilizar.
	//$soapclient = new nusoap_client('http://localhost/ProyectoSW/soapServicios/comprobarContrasena.php?wsdl',false);
	$soapclient = new nusoap_client('http://enamoya.esy.es/ProyectoSW/soapServicios/comprobarContrasena.php?wsdl',false);
	//Llamamos la función que habíamos implementado en el Web Service
	//e imprimimos lo que nos devuelve
	$result = $soapclient->call('comprobarContrasena', array('pass'=>$pass, 'cod'=>$cod));
	return $result;
}

function ownIP(){
 $ip= file_get_contents('http://myip.eu/');
 $ip= substr($ip,strpos($ip,'<font size=5>')+14);
 $ip= substr($ip,0,strpos($ip,'<br'));
 return $ip;
}
?>
