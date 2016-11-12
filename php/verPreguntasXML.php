<?php
session_start();
include_once ("funcionalidades.php");
?>



<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>verPreguntasXML</title>
  </head>
  <body>
  <div id='page-wrap'>
	<?php include('../adds/header.php'); ?>
	<?php include('../adds/navegation.php'); ?>
    <section class="main" id="s1">
		<div>
			<?php imprimirPreguntasXML(); ?>
		</div>
    </section>
	<?php include('../adds/footer.php'); ?>
</div>
</body>
</html>
