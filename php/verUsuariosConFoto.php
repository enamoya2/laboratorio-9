<?php
session_start();
include_once ("funcionalidades.php");

function imprimirUsuarios(){
	$mysqli = conect();
	$usuarios = mysqli_query($mysqli, "select * from usuario");
	echo '<table border=1> <tr> <th> NOMBRE </th> <th> EMAIL </th> <th> TELEFONO </th> <th> ESPECIALIDAD </th> <th> INTERESES </th> <th> FOTO </th></tr>';
	while ($row = mysqli_fetch_array( $usuarios )) {
		echo '<tr><td>' . $row['Nombre'] .'</td><td>' . $row['Email'] . '</td> <td>' . $row['Telefono'] . '</td> <td>' . $row['Especialidad'] . '</td><td>' . $row['Intereses'] . '</td> <td>' . '<img id="output" width="150px" src="' . $row['Foto'] . '"/>' . '</td></tr>';
	}
	echo '</table>';
	$usuarios->close();
	mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>Ver Usuarios</title>
  </head>
  <body>
  <div id='page-wrap'>
	<?php include('../adds/header.php'); ?>
	<?php include('../adds/navegation.php'); ?>
    <section class="main" id="s1">
		<div>
			<?php imprimirUsuarios(); ?>
		</div>
    </section>
	<?php include('../adds/footer.php'); ?>
</div>
</body>
</html>