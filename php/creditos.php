<?php session_start();?>

<!doctype html public>
<html>
	<head>
		<?php include('../adds/StyleAndMeta.php'); ?>
		<title> Pagina de creditos </title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="../JavaScript/googleMaps.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKBHzCuPwOfpvHe5DoFQFjO8DPO8foEyo&signed_in=true&callback=initMap" async defer>
		</script>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      #map {
        height: 100%;
      }
    </style>
	</head>
	<body>
		<div id='page-wrap'>
			<?php include('../adds/header.php'); ?>
			<?php include('../adds/navegation.php'); ?>
			<section class="main" id="s1">
					<h1>Autores</h1>
					<div id= 'autor1'>
						<h2> Iker Moya</h2>
						<p align= "center">Especialidad: Ingenieria de computadores</p>
						<img src='https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAAQlAAAAJDY2ZmY4ODAxLWNhODYtNDQ5ZC05NzQ0LWY3MjRlMGZiYjU4ZA.jpg'>
					</div>
					<div id= 'autor2'>
						<h2> Jose Augusto Ena</h2>
						<p align= "center">Especialidad: Computacion</p>
						<img src='https://scontent.xx.fbcdn.net/v/t1.0-9/12715578_756959777768577_1813122112924269595_n.jpg?oh=414c1e1193fb93e5181087c560d9c820&oe=58717469' width="15%" height="25%">
					</div>
					<div>
						<h2 align="center"> GEOLOCALIZACION </h2>
						<button id="Mapa_Cliente" onclick="mapa('<?php echo GetUserIP(); ?>')">Cliente</button>
						<button id="Mapa_Servidor" onclick="mapa('<?php echo $_SERVER['SERVER_ADDR']; ?>')">Servidor</button>
						<div id="map" style="display: none"></div>
					</div>
			</section>
			<?php include('../adds/footer.php'); ?>
		</div>
	</body>
</html>
