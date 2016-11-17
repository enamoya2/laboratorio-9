<?php
include_once ("funcionalidades.php");

if(!isset($_POST['emailR'])){
  echo '<p> Error </p>';
  return;
}

$email= $_POST['emailR'];
$mysqli = conect();
$usuarios = mysqli_query($mysqli, "select * from usuario where Email='$email'");
$cont= mysqli_num_rows($usuarios);
if($cont==0){
  echo '<p>No existe un usuario con ese mail.</p>';
  mysqli_close($mysqli);
  return;
}

$link = generarLink($email, $mysqli);
if($link== "false"){
  mysqli_close($mysqli);
  return;
}
if(enviarEmail($email, mensaje($link))){
	echo '<p> Se ha enviado un email a dicho usuario para reestablecer la contrasena<p>';
	echo '<p> Este servicio tarda aproximadamente 20 minutos<p>';
}
else
	echo 'Fallo al enviar correo al emai '.$email;
mysqli_close($mysqli);


function generarLink($email, $mysqli){
  $string = sha1($email.rand(1,99999999));
  $linkbase = mysqli_query($mysqli, "select * from link_contrasenas where Email='$email'");
  $cont= mysqli_num_rows($linkbase);
  if($cont==0){
    $sql="INSERT INTO link_contrasenas(Email, Link) VALUES ('$email', '$string')";
  	if (!mysqli_query($mysqli ,$sql)){
  		echo "Error: " . mysqli_error($mysqli);
  		return false;
  	}
  }else{
    $sql="UPDATE link_contrasenas SET Link='$string' WHERE Email='$email'";
  	if (!mysqli_query($mysqli ,$sql)){
  		echo "Error: " . mysqli_error($mysqli);
  		return false;
  	}
  }
  $enlace = 'http://www.enamoya.esy.es/ProyectoSW/php/resetearPassword.php?email='.$email.'&link='.$string;
  return $enlace;
}

function mensaje($link){

  return $mensaje = '<html>
     <head>
        <title>Restablecer contrasena</title>
     </head>
     <body>
       <p>Se ha recibido una solicitud para restablecer la contrasena de su cuenta.</p>
       <p>Haga clic en el siguiente enlace. Si no usted no hizo esta solicitud puede ignorar este mensaje.</p>
       <p>
         <strong>Enlace para restablecer su contrasena</strong><br>
         <a href="'.$link.'"> Restablecer contrasena </a>
       </p>
     </body>
    </html>';
}


function enviarEmail( $email, $mensaje ){


   $cabeceras = 'MIME-Version: 1.0' . "\r\n";
   $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
   $cabeceras .= 'From: EnaMoya <enamoya@enamoya.esy.es>' . "\r\n";
   // Se envia el correo al usuario
   return mail($email, "Recuperar contrasena", $mensaje, $cabeceras);
}

?>
