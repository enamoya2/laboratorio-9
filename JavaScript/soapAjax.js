

function validarEmail(input){
	if($('#email').val()== ""){
		$('#email').css('background-color', 'white');
		$('#emailVal').html("NO");
		$('#check').attr('src', '.');
		$('#check').hide();
		input.setCustomValidity('');
		return;
	}

		var parametros = {
			"email" : $('#email').val()
		};
		$.ajax({
		data: parametros,
		url: '../AjaxPhp/validarEmail.php',
		type: "POST",
		success: function (response) {
						if(response == "SI"){
							$('#email').css('background-color', '#66ff33');
							$('#check').attr('src', '../Images/Tick_verde.png');
							$('#check').show();
							input.setCustomValidity('');
						}
						else{
							$('#email').css('background-color', 'red');
							input.setCustomValidity('Email incorrecto');
							$('#check').attr('src', '../Images/Cruz_roja.png');
							$('#check').show();
						}
						$('#emailVal').html(response);
						activarBotton();
		},
				error:function(){$('#emailVal').html('Error')}
			});
}

function validarPass(){
	var input = document.getElementById("password");
	if($('#password').val()== ""){
		$('#password').css('background-color', 'white');
		$('#ticket').css('background-color', 'white');
		$('#passVal').html("NO");
		$('#check1').attr('src', '.');
		$('#check1').hide();
		input.setCustomValidity('');
		return;
	}
	if($('#ticket').val()== ""){
		$('#ticket').css('background-color', 'white');
		return;
	}
		var parametros = {
			"pass" : $('#password').val(),
			"cod" : $('#ticket').val()
		};
		$.ajax({
		data: parametros,
		url: '../AjaxPhp/comprobarPass.php',
		type: "POST",
		success: function (response) {
						if(response == "VALIDA"){
							$('#password').css('background-color', '#66ff33');
							$('#ticket').css('background-color', '#66ff33');
							$('#check1').attr('src', '../Images/Tick_verde.png');
							$('#check1').show();
							input.setCustomValidity('');
						}
						else if(response == "USUARIO NO AUTORIZADO"){
							$('#password').css('background-color', '#ff00ff');
							$('#ticket').css('background-color', '#ff00ff');
							input.setCustomValidity('Ticket no valido');
							$('#check1').attr('src', '../Images/prohibited.png');
							$('#check1').show();
						}
						else{
							$('#password').css('background-color', 'red');
							$('#ticket').css('background-color', '#66ff33');
							input.setCustomValidity('Pass incorrecto');
							$('#check1').attr('src', '../Images/Cruz_roja.png');
							$('#check1').show();
						}
						$('#passVal').html(response);
						activarBotton();
		},
				error:function(){$('#passVal').html('Error')}
			});
}

function activarBotton(){
	if(($('#emailVal').html() == "SI") && ($('#passVal').html() == "VALIDA"))
		$('#botsubmit').prop( "disabled", false );
	else
		$('#botsubmit').prop( "disabled", true );
}
