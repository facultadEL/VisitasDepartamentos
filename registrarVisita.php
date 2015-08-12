<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="codeLibrary.js"></script>
<script type="text/javascript" src="cryptor.js"></script>
<link rel="stylesheet" href="css/registroPasante.css">
	<title>Registro de Usuario</title>
	<script>
		var mailDictionary = [];

		function setMail(mailToSet)
		{
			mailDictionary.push(mailToSet);
		}

		function checkMail()
		{
			var mailABuscar = $('#mail').val();
			if($.inArray(mailABuscar, mailDictionary) != -1)
			{
				alert("Este mail ya se encuentra registrado");
				$('#mail').val("");
				$('#mail').focus();
			}
		}

		function setPass(passToSet){
			pass = passToSet;
		}
		//Esto se ejecuta cuando la página ya esta cargada
		$(document).ready(function(){
			//Acá se controla si trae un password. Lo trae cargado en caso de que sea un update de datos
			//Si no lo trae cargado, lo genera por primera vez que se registra.
			if (pass == null) {
				sD();
				lDD();
				longValue = 8;
				var pass = gP(longValue);
				var pass_encriptado = encrypt(pass, 'eof');

			}
			//Setea el hidden con el password
			$('#hiddenPass').val(pass);
			//$('#hiddenPassEnc').val(pass_encriptado);
		});

		function checkMail2()
		{
			var mail1 = $('#mail').val();
			var mail2 = $('#mail2').val();
			if(mail1 == mail2)
			{
				alert("No se puede utilizar el mismo mail");
				$('#mail2').val("");
				$('#mail2').focus();
			}
		}
	</script>
</head>
<body>
<?php

include_once "conexion.php";
include_once "libreria.php";

$verificarMail=traerSql('mail', 'pasante');
while($rowVerifMail=pg_fetch_array($verificarMail,NULL,PGSQL_ASSOC)){
	echo "<script>setMail('".$rowVerifMail['mail']."')</script>";
}

?>
<div id="formulario">
<h2>Registrar nueva visita</h2>
<form class="formNuevaVisita" name="f1" id="form2" action="guardarNuevaVisita.php" method="post">
<table align="center" width="100%">
	<tr width="100%">
		<td width="100%">
			<fieldset>
				<legend>Datos de la visita</legend>
					<table align="center" width="100%">
						<tr width="100%">
							<td width="10%" align="right">
								<label for="nombre">Nombre: </label>
							</td>
							<td width="30%">
								<input id="nombre" name="nombre" type="text" class="campoText" value="" required autofocus/>
							</td>
							<td width="10%" align="right">
								<label for="apellido">Apellido: </label>
							</td>
							<td width="30%">
								<input id="apellido" name="apellido" type="text" class="campoText" value="<?php echo $apellido; ?>" required/>
							</td>
							<td width="10%" align="right">
								<label for="nro_legajo">N&deg; Legajo: </label>
							</td>
							<td width="10%" colspan="3">
								<input id="nro_legajo" name="nro_legajo" pattern="[0-9]{4,5}" type="text" class="campoNro" value="<?php echo $nro_legajo; ?>" size="4" maxlength="5" required/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="tipodni">Tipo DNI:</label>
							</td>
							<td colspan="1">
								<select id="tipodni" name="tipodni" size="1">
									<?php
										$consultaTipoDNI=traerSql('*','tipo_dni');
										while($rowTipoDNI=pg_fetch_array($consultaTipoDNI)){
										if ($tipodni == $rowTipoDNI['id']){
					                        echo "<option value=".$rowTipoDNI['id']." selected>".$rowTipoDNI['nombre']."</option>";
										}else{
											echo "<option value=".$rowTipoDNI['id'].">".$rowTipoDNI['nombre']."</option>";
											}
										}
									?>
								</select>
							</td>
							<td colspan="1" align="right">
								<label for="nrodni">N&deg; DNI:</label>
							</td>
							<td colspan="5">
								<!-- <input id="nrodni" name="nrodni" type="text" class="campoText" onkeyup="maskDni()" onfocus="this.value = '';" pattern="[0-9]{1,2}+[.]{1}[0-9]{3}+[.]{1}[0-9]{3}" value="<?php //echo $nrodni; ?>" maxlength="10" autocomplete="off" required/> -->
								<input id="nrodni" name="nrodni" type="text" class="campoText" pattern="([0-9]{1}|[0-9]{2})[0-9]{3}[0-9]{3}" value="<?php echo $nrodni; ?>" maxlength="10" title="Solo n&uacute;meros" autocomplete="off" required/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="fec_nacimiento">Fecha Nac.: </label>
							</td>
							<td colspan="1">
								<input id="fec_nacimiento" name="fec_nacimiento" type="date" class="campoDate"  value="<?php echo $fec_nacimiento; ?>" placeholder="dd/mm/aaaa" maxlength="10" required/>
							</td>
							<td colspan="1" align="right">
								<label for="loc_nacimiento">Lugar Nac.: </label>
							</td>
							<td colspan="5">
								<input id="loc_nacimiento" name="loc_nacimiento" type="text" spellcheck="true" class="campoText" value="<?php echo $loc_nacimiento; ?>" required/>
							</td>
						</tr>
						<tr width="100%">
							<td  width="100%" colspan="8"><hr size="2" width="100%" align="center"/></td>
						</tr>
						<tr width="100%">
							<td  width="100%" colspan="8">
								<legend id="leyenda">*Domicilio donde vive</legend>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="loc_viviendo">Localidad:</label>
							</td>
							<td colspan="1">
								<input id="loc_viviendo" name="loc_viviendo" type="text" spellcheck="true" class="campoText" value="<?php echo $loc_viviendo; ?>" required/>
							</td>
							<td colspan="1" align="right">
								<label for="prov_viviendo">Provincia:</label>
							</td>
							<td colspan="1">
								<input id="prov_viviendo" name="prov_viviendo" type="text" spellcheck="true" class="campoText" value="<?php echo $prov_viviendo; ?>" required/>
							</td>
							<td colspan="1" align="right">
								<label for="codpos">C.P.:</label>
							</td>
							<td colspan="3">
								<input id="codpos" name="codpos" type="text" class="campoNro" pattern="[0-9]{4}" value="<?php echo $codpos; ?>" required maxlength="4" size="4"/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" width="10%" align="right">
								<label for="calle">Calle: </label>
							</td>
							<td colspan="1" width="30%">
								<input id="calle" name="calle" type="text" class="campoText" value="<?php echo $calle; ?>" required/>
							</td>
							<td colspan="1" width="10%" align="right">
								<label for="nrocalle">N&deg;: </label>
							</td>
							<td colspan="1" width="10%">
								<input id="nrocalle" name="nrocalle" pattern="[0-9]{2,5}" maxlength="5" type="text" class="campoNro" size="4" value="<?php echo $nrocalle; ?>" title="El n&uacute;mero debe tener de 2 a 5 cifras" required/>
							</td>
							<td colspan="1" width="10%" align="right">
								<label for="piso">Piso: </label>
							</td>
							<td colspan="1" width="10%">
								<input id="piso" name="piso" type="text" pattern="[0-9]{2}" class="campoNro" size="4" value="<?php echo $piso; ?>"/>
							</td>
							<td colspan="1" width="10%" align="right">
								<label for="dpto">Dpto: </label>
							</td>
							<td colspan="1" width="10%">
								<input id="dpto" name="dpto" type="text" size="1" class="campoNro" value="<?php echo $dpto; ?>"/>
							</td>
						</tr>
					</table>
			</fieldset>
			<fieldset>
				<legend>Datos Contacto</legend>
					<table align="center" width="100%">
						<tr width="100%">
							<td width="10%" align="right">
								<label for="caracfijo">Tel&eacute;fono Fijo: </label>
							</td>
							<td width="5%">
								<input id="caracfijo" name="caracfijo" type="text" class="campoNro" pattern="[1-9]{2,4}" placeholder="Sin 0" value="<?php echo $caracfijo; ?>" size="3" maxlength="5"/>
							</td>
							<td width="35%">
								<input id="nrofijo" name="nrofijo" type="text" class="campoTextTel" pattern="[0-9]{6,8}" value="<?php echo $nrofijo; ?>"/>
							</td>
							<td width="10%" align="right">
								<label for="caraccel">Celular: </label>
							</td>
							<td width="5%">
								<input id="caraccel" name="caraccel" type="text" class="campoNro" pattern="[1-9]{2,4}" placeholder="Sin 0" value="<?php echo $caraccel; ?>" size="3" maxlength="5" required/>
							</td>
							<td width="35%">
								<input id="nrocelular" name="nrocelular" type="text" class="campoTextTel" pattern="[0-9]{6,8}" placeholder="Sin 15" value="<?php echo $nrocelular; ?>" required/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="mail">Mail 1: </label>
							</td>
							<td colspan="2">
								<input id="mail" name="mail" type="email" class="campoText" value="<?php echo $mail; ?>" onchange="checkMail();" autocomplete="off" required/>
							</td>
							<td colspan="1" align="right">
								<label for="mail2">Mail 2: </label>
							</td>
							<td colspan="2">
								<input id="mail2" name="mail2" type="email" onchange="checkMail2();" placeholder="Opcional" class="campoText" value="<?php echo $mail2; ?>"/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="facebook">Facebook: </label>
							</td>
							<td colspan="2">
								<input id="facebook" name="facebook" type="text" class="campoText" placeholder="&iquest;Como te encuentro?" value="<?php echo $facebook; ?>"/>
							</td>
							<td colspan="1" align="right">
								<label for="twitter">Twitter: </label>
							</td>
							<td colspan="2">
								<input id="twitter" name="twitter" type="text" class="campoText" value="<?php echo $twitter; ?>"/>
							</td>
						</tr>
					</table>
			</fieldset>
			<fieldset>
				<legend>Alumnos</legend>
					<table align="center" width="100%">
						<tr width="100%">
							<td width="10%" align="right">
								<label for="loc_trabajo">Localidad:</label>
							</td>
							<td width="30%">
								<input id="loc_trabajo" name="loc_trabajo" type="text" class="campoText" spellcheck="true" value="<?php echo $loc_trabajo; ?>"/>
							</td>
							<td width="10%" align="right">
								<label for="prov_trabajo">Provincia:</label>
							</td>
							<td width="30%">
								<input id="prov_trabajo" name="prov_trabajo" type="text" class="campoText" spellcheck="true" value="<?php echo $prov_trabajo; ?>"/>
							</td>
							<td width="10%" align="right">
								<label for="codpos2">C.P.:</label>
							</td>
							<td width="10%">
								<input id="codpos2" name="codpos2" type="text" class="campoNro" pattern="[0-9]{4}" value="<?php echo $codpos2; ?>" maxlength="4" size="2"/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="empresa_trabaja">Empresa: </label>
							</td>
							<td colspan="5">
								<input id="empresa_trabaja" name="empresa_trabaja" type="text" class="campoText" value="<?php echo $empresa_trabaja; ?>"/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="perfil_laboral">Perfil Laboral: </label>
							</td>
							<td colspan="5">
								<textarea id="perfil_laboral" name="perfil_laboral" class="campoArea" value="" spellcheck="true" ><?php echo $perfil_laboral; ?></textarea>
							</td>
						</tr>
					</table>
			</fieldset>
		</td>
	</tr>
</table>
</div>
<table id="tablaBtn" align="center">
	<tr width="100%">
		<td width="50%" align="right">
			<?php if($id_Pasante != 0){?>
				<a href="verAlumno.php?idAlumno=<?php echo $id_Pasante;?>&titulo_pasante=<?php echo $carrera_fk;?>"><input type="button" id="btn_cancelar" value="Cancelar"></a>
			<?php }else{?>
				<a href="escritorioVisitas.php"><input type="button" id="btn_cancelar" value="Cancelar"></a>
			<?php }; 
				include_once "cerrar_conexion.php";
			?>
		</td>	
		<td width="50%" align="left">
			<input class="submit" type="submit" value="Guardar"/>
		</td>
	</tr>
</table>
</form>
</body>
</html>