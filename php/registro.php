<?php session_start();?>
<!doctype html public>
<html>
	<head>
		<?php include('../adds/StyleAndMeta.php'); ?>
		<title> Pagina de registro </title>
		<script type="text/javascript" src="../JavaScript/Validaciones.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="../JavaScript/soapAjax.js"></script>
	</head>
	<body>
		<div id='page-wrap'>
		<?php include('../adds/header.php'); ?>
		<?php include('../adds/navegation.php'); ?>
		<section class="main" id="s1">

		<form id="registro" method="post" onSubmit='return validar()' action="../php/RegistrarConFoto.php" enctype="multipart/form-data">
			Registro de un usuario, los campos marcados con (*) son obligatorios
			</br></br>
			<TABLE class="tabla" BORDER=0>
				<TR>
					<TD>Nombre y Apellidos (*)</TD>
					<TD><INPUT class="inputs" type=text name="nombre" id="nombre" required></TD>
				</TR>
				<TR>
					<TD>Email (*)</TD>
					<TD><INPUT class="inputs" type=text name="email" id="email" onchange="validarEmail(this)" required>
						<img id="check" class="check" src="" style="display: none"/>
						<div id="emailVal" onchange="activarBotton()" style="display: none"></div>
					</TD>
				</TR>
				<TR>
					<TD>Password (*)</TD>
					<TD><INPUT class="inputs" type=password name="password" id="password" onchange="validarPass()" required>
						<img id="check1" class="check" src="" style="display: none"/>
						<div id="passVal" style="display: none"></div>
					</TD>
				</TR>

				<TR>
					<TD>Ticket (*)</TD>
					<TD><INPUT class="inputs" type=text name="ticket" id="ticket" onchange="validarPass()" required></TD>
				</TR>

				<TD>Repite el password (*)</TD>
				<TD><INPUT class="inputs" type=password name="password1" id="password1" required>
				</TD>
			</TR>

				<TR>
					<TD>Numero de telefono (*)</TD>
					<TD><INPUT class="inputs" type=text name="tlf" id="tlf" required></TD>
				</TR>
				<TR>
					<TD>Especialidad (*)</TD>
					<TD>
						<SELECT class="inputs" name="especialidad" id="especialidad" onchange="modificarcampo()" required>
							<OPTION VALUE="hardware">Ingenieria de computadores</OPTION>
							<OPTION VALUE="compu">Computacion</OPTION>
							<OPTION VALUE="software">Ingenieria del software</OPTION>
							<OPTION VALUE="otro">Otro</OPTION>
						</SELECT>
						<span name="textootro" id="textootro" style="display: none">Introduce la otra especialidad</span>
						<input type="text" name="otraesp" id="otraesp" style="display: none">
					</TD>
				</TR>
				<TR>
					<TD>Tecnologias y herramientas en las que esta interesado</TD>
					<TD>
					<TEXTAREA class="inputs" name="intereses" id="intereses"></TEXTAREA>
					</TD>
				</TR>
				<TR>
					<TD>Sube una imagen tuya si lo deseas</TD>
					<TD>
					<input name="foto" id="foto" type="file" accept="image/*" onchange="loadFile(event)" />
					</TD>
				</TR>
				<TR>
					<TD></TD>
					<TD>
						<img id="output" width="150px" style="display: none"  src=""/>
					</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>
						<INPUT type="submit" id="botsubmit"value="Enviar" disabled=true>
					</TD>
				</TR>
			</TABLE>
		</form>
		</section>
		<?php include('../adds/footer.php'); ?>
	</div>
	</body>
</html>
