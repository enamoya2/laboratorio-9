<?php session_start(); ?>

<!DOCTYPE html>
<html>
  <head>
	<?php include('../adds/StyleAndMeta.php'); ?>
	<title>Obtener Datos</title>
	<script type="text/javascript">
    function completar(){
      var enc=false;
	  var xmlDoc = document.getElementById('datos').contentDocument;
	  var listaemails=xmlDoc.getElementsByTagName("email");
      var correo = document.getElementById("email").value;
      
	  var listanombres = xmlDoc.getElementsByTagName("nombre");
	  var listaap1=xmlDoc.getElementsByTagName("apellido1");
	  var listaap2=xmlDoc.getElementsByTagName("apellido2");
      var listatelefonos=xmlDoc.getElementsByTagName("telefono");
	  for (var i = 0; i < listaemails.length && enc==false; i++) {
        if (correo==listaemails[i].childNodes[0].nodeValue){
			document.getElementById('name').value = listanombres[i].childNodes[0].nodeValue;
			document.getElementById('ap1').value = listaap1[i].childNodes[0].nodeValue;
			document.getElementById('ap2').value = listaap2[i].childNodes[0].nodeValue;
			document.getElementById('tlf').value = listatelefonos[i].childNodes[0].nodeValue;
			enc=true;
		}
       }
        if (!enc){
          alert ('Este correo no está registrado en la UPV/EHU. Introduzca otro');
		  document.getElementById('name').value = "";
		  document.getElementById('ap1').value = "";
		  document.getElementById('ap2').value = "";
		  document.getElementById('tlf').value = "";
        }
      }
    </script>
  </head>
  <body>
 <OBJECT id="datos" data="../xml/usuarios.xml" type="text/xml" style="display:none">
  </OBJECT>
  <div id='page-wrap'>
	<?php include('../adds/header.php'); ?>
	<?php include('../adds/navegation.php'); ?>
    <section class="main" id="s1">
      <div align="center">
        <h1>Buscar Datos ...</h1><BR>
        <FORM METHOD="POST" ACTION="insertar.php">
          Email <BR>
          <INPUT TYPE="TEXT" NAME="email" id="email" required><BR>
		   Nombre <BR>
          <INPUT TYPE="TEXT" NAME="name" id="name" required><BR>
		   Apellido 1 <BR>
          <INPUT TYPE="TEXT" NAME="ap1" id="ap1" required><BR>
		  Apellido 2 <BR>
          <INPUT TYPE="TEXT" NAME="ap2" id="ap2" required><BR>
          Teléfono <BR>
          <INPUT TYPE="TEXT" NAME="tlf" id="tlf" required="required"
          maxlength="9" pattern="[0-9]{9}" />
          <br><br>
          <INPUT TYPE="button" value="Autocompletar" onClick="javascript:completar()">
        </FORM>
      </div>
    </section>
	<?php include('../adds/footer.php'); ?>
</div>
</body>
</html>
