<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
<!--link rel="stylesheet" href="css/registroPasante.css"-->
	<title>Registro de Visitas</title>
	<script>
		var tieneDatos = false;

		var cantAlumnosAgregados = 0;
		var sep = '/--/';
		var sepTotal = '/-/-/';
		var dniAId = '#dniAlumno';
		var apellidoAId = '#apellidoAlumno';
		var nombreAId = '#nombreAlumno';
		var fechaAId = '#fechaAlumno';
		var mailAId = '#mailAlumno';
		var hiddenAId = '#idHiddenAlumno';
		var stringAlumnosPasar = "";

		var idVisita,nombreVisita, catedra, profesorCatedra, profesorVisita, movilidad,
		fecha, nombreEmpresa, areaEmpresa,nombreContacto,apellidoContacto,
		cargoContacto,mailContacto,telefonoEmpresa,motivoVisita;
		
		function sacarColor(me)
		{
	    	// $(me).css('border-color','initial');
	    	// $(me).css('outline','1px');
	    	$(me).css('box-shadow','0px 0px 10px 1px #ccc');
		}

		function setDatosVisita(datos)
		{
			tieneDatos = true;
			var vDatos = datos.split(sep);
			idVisita = vDatos[0];
			nombreVisita = vDatos[1];
			catedra = vDatos[2];
			profesorCatedra = vDatos[3];
			profesorVisita = vDatos[4];
			movilidad = vDatos[5];
			fecha = vDatos[6];
			nombreEmpresa = vDatos[7];
			areaEmpresa = vDatos[8];
			nombreContacto = vDatos[9];
			apellidoContacto = vDatos[10];
			cargoContacto = vDatos[11];
			mailContacto = vDatos[12];
			telefonoEmpresa = vDatos[13];
			motivoVisita = vDatos[14];
		}

		function setAlumnoXVisita(datos)
		{
			cantAlumnosAgregados++;
			alumnosAgregados.push(datos);

		}

		var alumnoDictionary = [];
		var alumnosAgregados = []

		function setAlumno(alumnoToSet)
		{
			alumnoDictionary.push(alumnoToSet);
		}


		function checkAlumno()
		{			
			dniNuevoAlumno = $(dniAId).val();
			for(var i = 0; i < alumnoDictionary.length; i++)
			{
				var vDatosAlumno = alumnoDictionary[i].split(sep);
				if(dniNuevoAlumno == vDatosAlumno[0])
				{
					$(apellidoAId).val(vDatosAlumno[1]);
					$(nombreAId).val(vDatosAlumno[2]);
					$(fechaAId).val(vDatosAlumno[3]);
					$(mailAId).val(vDatosAlumno[4]);
					$(hiddenAId).val(vDatosAlumno[5]);
				}
			}
		}

		function toCapitalLetter(originalString)
		{
			originalString = originalString.toLowerCase();
			returnString = originalString[0].toUpperCase()+originalString.substr(1);
			return returnString;
		}

		function controlAlumnos()
		{
			dniActual = $(dniAId).val();
			for(var i = 0; i < alumnosAgregados.length; i++)
			{
				vDatosAlumnoAgregado = alumnosAgregados[i].split(sep);
				if(dniActual == vDatosAlumnoAgregado[0])
				{
					alert("Alumno Agregado!");
					return false;
				}
			}
			return true;
		}

		function addAlumno()
		{
			if(!controlAlumnos()) return false;
			if(!controlVacio(apellidoAId)) return false;
			if(!controlVacio(nombreAId)) return false;
			if(!controlVacio(fechaAId)) return false;
			/*
			Seguir control vacio
			*/
			cantAlumnosAgregados++;
			//stringAlumnosPasar += $(dniAId).val()+sep+$(apellidoAId).val()+sep+$(nombreAId).val()+sep+$(fechaAId).val()+sep+$(mailAId).val()+sep+$(hiddenAId)+sepTotal;
			stringToPush = $(dniAId).val()+sep+toCapitalLetter($(apellidoAId).val())+sep+toCapitalLetter($(nombreAId).val())+sep+$(fechaAId).val()+sep+$(mailAId).val()+sep+$(hiddenAId).val();
			alumnosAgregados.push(stringToPush);

			actualizarTabla();
			limpiarPantalla();

		}

		function limpiarPantalla()
		{
			$(dniAId).val('');
			$(apellidoAId).val('');
			$(nombreAId).val('');
			$(fechaAId).val('');
			$(mailAId).val('');
			$(hiddenAId).val('-1');
		}

		function actualizarTabla()
		{
			stringToAdd = '';
			$('#cuerpoTabla').html('');

			for(var i = 0; i < alumnosAgregados.length; i++)
			{
				var vAlumno = alumnosAgregados[i].split(sep);
				stringToAdd += '<tr><td>'+vAlumno[0]+'</td><td>'+vAlumno[1]+'</td><td>'+vAlumno[2]+'</td><td>'+vAlumno[3]+'</td><td>'+vAlumno[4]+'</td><td><input type="button" value="X" onclick="borrarAlumno('+"'"+i+"'"+')"</td></tr>';
			}
			$('#cuerpoTabla').html(stringToAdd);
		}

		function borrarAlumno(index)
		{
			//Funcion que borra
			alumnosAgregados.splice(index,1);
			cantAlumnosAgregados--;
			actualizarTabla();
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

		function controlSubmit()
		{
			//Llamar a control vacio con las variables obligatorias
			if(!controlVacio('#nombreVisita')) return false;
			if(!controlVacio('#fechaVisita')) return false;
			if(!controlVacio('#catedra')) return false;
			if(!controlVacio('#profesorCatedra')) return false;
			if(!controlVacio('#movilidad')) return false;
			if(!controlVacio('#motivo')) return false;
			if(!controlVacio('#nombreEmpresa')) return false;
			if(!controlVacio('#areaEmpresa')) return false;
			if(!controlVacio('#caracteristicaEmpresa')) return false;
			if(!controlVacio('#telefonoEmpresa')) return false;
			if(!controlVacio('#nombreContacto')) return false;
			if(!controlVacio('#apellidoContacto')) return false;
			if(!controlVacio('#cargoContacto')) return false;

			if(cantAlumnosAgregados < 1)
			{
				return false;
			}
			else
			{
				datosAlumnosEnviar=""
				for(var i = 0; i < alumnosAgregados.length; i++)
				{
					datosAlumnosEnviar += alumnosAgregados[i];
					if(i < (alumnosAgregados.length - 1))
					{
						datosAlumnosEnviar += sepTotal;
					}
				}
				$('#datosAlumnos').val(datosAlumnosEnviar);
			}

			return true;
		}

		$(document).ready(function(){
			if(tieneDatos)
			{
				$('#idVisitaHidden').val(idVisita);
				$('#nombreVisita').val(nombreVisita);
				$('#fechaVisita').val(fecha);
				$('#catedra').val(catedra);
				$('#profesorCatedra').val(profesorCatedra);
				$('#profesorVisita').val(profesorVisita);
				$('#movilidad').val(movilidad);
				$('#motivo').val(motivoVisita);
				$('#nombreEmpresa').val(nombreEmpresa);
				$('#areaEmpresa').val(areaEmpresa);
				vTelefonoEmpresa = telefonoEmpresa.split('-');
				$('#caracteristicaEmpresa').val(vTelefonoEmpresa[0]);
				$('#telefonoEmpresa').val(vTelefonoEmpresa[1]);
				$('#nombreContacto').val(nombreContacto);
				$('#apellidoContacto').val(apellidoContacto);
				$('#cargoContacto').val(cargoContacto);
				$('#mailContacto').val(mailContacto);

				actualizarTabla();
			}
		});
	</script>
</head>
<body>
<?php

include_once "conexion.php";
include_once "scripts/libreria.php";

$idVisita = (empty($_REQUEST['idVisita'])) ? 0 : $_REQUEST['idVisita'];

$sep = '/--/';

if($idVisita != 0)
{
	$condicion = "id=$idVisita LIMIT 1;";
	$sqlVisita = traerSqlCondicion('*','visita',$condicion);
	$rowVisita = pg_fetch_array($sqlVisita);
	$datosVisita = $rowVisita['id'].$sep;
	$datosVisita .= $rowVisita['nombre'].$sep;
	$datosVisita .= $rowVisita['catedra'].$sep;
	$datosVisita .= $rowVisita['profesor_catedra'].$sep;
	$datosVisita .= $rowVisita['profesor_visita'].$sep;
	$datosVisita .= $rowVisita['movilidad'].$sep;
	$datosVisita .= $rowVisita['fecha'].$sep;
	$datosVisita .= $rowVisita['nombre_empresa'].$sep;
	$datosVisita .= $rowVisita['area_empresa'].$sep;
	$datosVisita .= $rowVisita['nombre_contacto'].$sep;
	$datosVisita .= $rowVisita['apellido_contacto'].$sep;
	$datosVisita .= $rowVisita['cargo_contacto'].$sep;
	$datosVisita .= $rowVisita['mail_contacto'].$sep;
	$datosVisita .= $rowVisita['telefono_empresa'].$sep;
	$datosVisita .= $rowVisita['motivo_visita'];

	echo "<script>setDatosVisita('".$datosVisita."')</script>";

	$condicion = "visita_fk=".$rowVisita['id'];
	$sqlAlumnoXVisita = traerSqlCondicion('alumno.*','alumnoxvisita INNER JOIN alumno ON(alumno.id = alumnoxvisita.alumno_fk)',$condicion);
	while($rowAlumnoXVisita = pg_fetch_array($sqlAlumnoXVisita))
	{
		$datosAlumno = $rowAlumnoXVisita['dni'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['apellido'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['nombre'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['fecha_nac'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['mail'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['id'];
		
		echo "<script>setAlumnoXVisita('".$datosAlumno."')</script>";
	}

}

$cantAlumnos = contarRegistro('id','alumno',null);
if($cantAlumnos > 0)
{
	$sqlAlumnos = traerSql('*','alumno');
	while($rowAlumnos = pg_fetch_array($sqlAlumnos))
	{
		$dataAlumno = $rowAlumnos['dni'].$sep.$rowAlumnos['apellido'].$sep.$rowAlumnos['nombre'].$sep.$rowAlumnos['fecha_nac'].$sep.$rowAlumnos['mail'].$sep.$rowAlumnos['id'];
		echo "<script>setAlumno('".$dataAlumno."')</script>";
	}
}

?>
<div id="formulario">
<h2>Registrar nueva visita</h2>
<form class="formNuevaVisita" name="f1" id="form2" action="guardarVisita.php" onsubmit="return controlSubmit();" method="post">
<div>
	<strong>Ese alumno ya est&aacute; agregado</strong>
</div>
<table align="center" width="100%">
	<tr width="100%">
		<td width="100%">
			<fieldset>
				<legend>Datos de la visita</legend>
					<input type="hidden" name="idVisitaHidden" id="idVisitaHidden" value="0"/>
					<input type="hidden" name="datosAlumnos" id="datosAlumnos" value="" />
					<label for="nombreVisita">Nombre: </label>
					<input type="text" name="nombreVisita" id="nombreVisita" onkeydown="sacarColor(this)"/>
					<label for="fechaVisita">Fecha: </label>
					<input type="date" name="fechaVisita" id="fechaVisita" onkeydown="sacarColor(this)"/>
					<label for="catedra">C&aacute;tedra:</label>
					<input type="text" name="catedra" id="catedra" onkeydown="sacarColor(this)"/>
					<label for="profesorCatedra">Profesor a cargo de la c&aacute;tedra:</label>
					<input type="text" name="profesorCatedra" id="profesorCatedra" onkeydown="sacarColor(this)"/>
					<label for="profesorVisita">Profesor a cargo de la visita:</label>
					<input type="text" name="profesorVisita" id="profesorVisita" />
					<label for="movilidad">Medio de movilidad:</label>
					<input type="text" name="movilidad" id="movilidad" onkeydown="sacarColor(this)"/>
					<label for="motivo">Motivo de la visita:</label>
					<textarea name="motivo" id="motivo" onkeydown="sacarColor(this)"></textarea>
			</fieldset>
			<fieldset>
				<legend>Datos de la Empresa</legend>
					<label for="nombreEmpresa">Nombre de la empresa:</label>
					<input type="text" name="nombreEmpresa" id="nombreEmpresa" onkeydown="sacarColor(this)"/>
					<label for="areaEmpresa">&Aacute;rea de la empresa:</label>
					<input type="text" name="areaEmpresa" id="areaEmpresa" onkeydown="sacarColor(this)"/>
					<label for="caracteristicaEmpresa">T&eacute;lefono:</label>
					<input type="text" name="caracteristicaEmpresa" id="caracteristicaEmpresa" onkeydown="sacarColor(this)"/>
					<input type="text" name="telefonoEmpresa" id="telefonoEmpresa" onkeydown="sacarColor(this)"/>
			</fieldset>
			<fieldset>
				<legend>Datos del Contacto</legend>
					<label for="nombreContacto">Nombre:</label>
					<input type="text" name="nombreContacto" id="nombreContacto" onkeydown="sacarColor(this)"/>
					<label for="apellidoContacto">Apellido:</label>
					<input type="text" name="apellidoContacto" id="apellidoContacto" onkeydown="sacarColor(this)"/>
					<label for="cargoContacto">Cargo que ocupa:</label>
					<input type="text" name="cargoContacto" id="cargoContacto" onkeydown="sacarColor(this)"/>
					<label for="mailContacto">Mail:</label>
					<input type="mail" name="mailContacto" id="mailContacto" />
			</fieldset>
			<fieldset>
				<legend>Alumnos</legend>
					<label for="dniAlumno">DNI: </label>
					<input type="text" name="dniAlumno" id="dniAlumno" onblur="checkAlumno()"/>
					<input type="hidden" name="idHiddenAlumno" id="idHiddenAlumno" value="-1"/>
					<label for="nombreAlumno">Nombre:</label>
					<input type="text" name="nombreAlumno" id="nombreAlumno" />
					<label for="apellidoAlumno">Apellido:</label>
					<input type="text" name="apellidoAlumno" id="apellidoAlumno" />
					<label for="fechaAlumno">Fecha de Nacimiento:</label>
					<input type="date" name="fechaAlumno" id="fechaAlumno" />
					<label for="mailAlumno">Mail:</label>
					<input type="mail" name="mailAlumno" id="mailAlumno" />
					<input type="button" id="agregarAlumno" name="agregarAlumno" value="Agregar" onclick="addAlumno();"/>
					<table id="tablaTotalAlumnos">
						<thead>
							<td>
								DNI
							</td>
							<td>
								Apellido
							</td>
							<td>
								Nombre
							</td>
							<td>
								Fecha Nacimiento
							</td>
							<td>
								Mail
							</td>
							<td>
							</td>
						</thead>
						<tbody id="cuerpoTabla">
							
						</tbody>
					</table>
			</fieldset>
		</td>
	</tr>
</table>
</div>
<table id="tablaBtn" align="center">
	<tr width="100%">
		<!--td width="50%" align="right">
			<?php if($id_Pasante != 0){?>
				<a href="verAlumno.php?idAlumno=<?php echo $id_Pasante;?>&titulo_pasante=<?php echo $carrera_fk;?>"><input type="button" id="btn_cancelar" value="Cancelar"></a>
			<?php }else{?>
				<a href="escritorioVisitas.php"><input type="button" id="btn_cancelar" value="Cancelar"></a>
			<?php }; 
				include_once "cerrar_conexion.php";
			?>
		</td-->	
		<td width="50%" align="left">
			<input class="submit" type="submit" value="Guardar"/>
		</td>
	</tr>
</table>
</form>
</body>
</html>