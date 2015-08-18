<?php
	session_start(); // al volver al index si existe una session, esta sera destruida, existen formas de conservarlas como con un if(session_start()!= NULL). Pero por el momento para el ejemplo no es valido.

$usuario = (empty($_SESSION['usuario'])) ? NULL : $_SESSION['usuario'];
	if ($usuario != NULL) {
		$_SESSION['usuario'] = NULL;
 	 	$_SESSION['password'] = NULL;
	}

	session_destroy(); // Se destruye la session existente de esta forma no permite el duplicado.
?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<script type='text/javascript' src="scripts/jquery-1.11.3.min.js"></script>
	<!--script type='text/javascript' src="scripts/cryptor.js"></script-->
	<link rel="stylesheet" href="css/login.css">
	<script>
		var pasa;
		var dataDictionary = [];

		function setData(dataToPush){
			dataDictionary.push(dataToPush);
		}

		function validateData(){

			var parametros = {
                "user" : $('#user').val().toLowerCase(),
                "pass" : $('#password').val()
        	};

   			var pasa;
			$.ajax({
				type: "POST",
				url: "controlUsuario.php",
				data: parametros,
				async: false,
				success:  function (response) { //Funcion que ejecuta si todo pasa bien. El response es los datos que manda el otro archivo
                        if(response == '1')
                        {
                        	$('#form').submit();
                        }
                        else
                        {
                        	switch(response)
                        	{
                        		case '0':
                        		case '2':
                        			alert("Datos de ingreso incorrectos");
                        			break;
                        		case '3':
                        			alert("Usuario deshabilitado");
                        			break;
                        		default:
                        			alert("Comunicarse con extension");
                        			break;
                        	}
                        }
                },
				error: function (msg) {
					alert("No se pudo validar el usuario. Contactarse con Secretaría de Extensión");
				}
			});
		}

		function pulsar(e)
		{
			if(e.keyCode == 13)
			{
				if(!controlVacio('#user')) return false;
				if(!controlVacio('#password')) return false;

				validateData();
			}
		}

		function controlVacio(nombreSelector)
		{
			if($.trim($(nombreSelector).val()) == '')
	    	{
	        	// $(nombreSelector).css('border-color','red');
	        	// $(nombreSelector).css('outline','0px');
	        	$(nombreSelector).css('box-shadow','0px 0px 10px 5px #f24d4d');

		        $(nombreSelector).focus();
	    	    return false;
	    	}
	    	return true;
		}

		function sacarColor(me)
		{
	    	// $(me).css('border-color','initial');
	    	// $(me).css('outline','1px');
	    	$(me).css('box-shadow','0px 0px 10px 1px #ccc');
		}

	</script>
</head>
<body>
<?php
/*
include_once "conexion.php";
include_once "scripts/libreria.php";

	$sql = traerSql('mail,password','usuario ORDER BY id');
	while($rowData=pg_fetch_array($sql,NULL,PGSQL_ASSOC)){
		$dataToPass = strtolower($rowData['mail']).'/--/'.$rowData['password'];
		echo "<script>setData('".$dataToPass."')</script>";
		//echo $dataToPass.'<br>';
	}

include_once "cerrar_conexion.php";
*/
?>
	<div id="login">
		<h2>Login</h2>
		<form action="verificarLogin.php" id="form" method="post">
				<table width="100%" align="center">
					<tr>
						<td>
							<label for="email">Usuario:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" id="user" name="usuario" value="" placeholder="Usuario" autofocus required onkeydown="pulsar(event);sacarColor(this);" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="password">Contrase&ntilde;a:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" id="password" name="password" value="" placeholder="Contrase&ntilde;a" required onkeydown="pulsar(event);sacarColor(this);"/>
						</td>
					</tr>  
					<tr>
						<td>
							<hr width="100%">
						</td>
					</tr>
					<tr>
						<td>
							<input type="button" id="btn_enviar" value="Acceder" onclick="validateData();">
						</td>
					</tr>
					<tr>
						<td>
							<a href="olvidoPassword.php"><input type="button" id="btn_olvpass" value="Olvid&eacute; mi contrase&ntilde;a"></a>
						</td>
					</tr>
				</table>
		</form>
	</div> <!-- end login -->
</body>	
</html>