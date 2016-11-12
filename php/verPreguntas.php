<?php
session_start();
?>


<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>Insertar Pregunta</title>
  </head>
  <body>
	<div id='page-wrap'>
		<?php include('../adds/header.php'); ?>
		<?php include('../adds/navegation.php'); ?>
		<section class="main" id="s1">
			<div>
				<?php
				echo '<br/><a href="verPreguntasXML.php"> Ver Preguntas XML </a>';
        echo '<br/><a href="../xml/preguntas.xml"> Ver Preguntas XSL </a>';
				echo '<br/><a href="verPreguntasBD.php"> Ver Preguntas BD </a>';
				?>
			</div>
		</section>
		<?php include('../adds/footer.php'); ?>
	</div>
</body>
</html>
