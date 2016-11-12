<?php include_once ("funcionalidades.php"); ?>

<header class='main' id='h1'>
<?php			
	if(!isLogueado()){
?>
		<span class="right"><a href="../php/registro.php">Registrarse</a></span>
		<span class="right"><a href="../php/login.php">Login</a></span>
<?php
	}
	else{
?>
		<span class="right"><a href="../php/logout.php">Logout</a></span>
	<?php }
	mensajeHeader();
	?>
	<h2>Quiz: el juego de las preguntas</h2>
</header>