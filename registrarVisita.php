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
		var tieneDatos = false;
		var nombreVisita;
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

		function setDatosVisita(datos)
		{
			tieneDatos = true;
			var vDatos = datos.split('/--/');
			nombreVisita
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

		function addAlumno()
		{
			if(!controlVacio(apellidoAId)) return false;
			if(!controlVacio(nombreAId)) return false;
			if(!controlVacio(fechaAId)) return false;
			/*
			Seguir control vacio
			*/
			cantAlumnosAgregados++;
			//stringAlumnosPasar += $(dniAId).val()+sep+$(apellidoAId).val()+sep+$(nombreAId).val()+sep+$(fechaAId).val()+sep+$(mailAId).val()+sep+$(hiddenAId)+sepTotal;
			stringToPush = $(dniAId).val()+sep+$(apellidoAId).val()+sep+$(nombreAId).val()+sep+$(fechaAId).val()+sep+$(mailAId).val()+sep+$(hiddenAId);
			alumnosAgregados.push(stringToPush);

			actualizarTabla();
			limpiarPantalla();

		}

		function limpiarPantalla()
		{
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
			alumnosAgregados.
			actualizarTabla();
		}

		function controlVacio()
		{

		}

		$(document).ready(function(){
			if(tieneDatos)
			{

			}
		});
	</script>
</head>
<body>
<?php

include_once "conexion.php";
include_once "libreria.php";

$idVisita = (empty($_REQUEST['idVisita'])) ? 0 : $_REQUEST['idVisita'];

if($idVisita != 0)
{
	$condicion = "id=$idVisita LIMIT 1;";
	$sqlVisita = traerSqlCondicion('*','visita',$condicion);
	$rowVisita = pg_fetch_array($sqlVisita);

}

$cantAlumnos = contarRegistro('id','alumno');
if($cantAlumnos > 0)
{
	$sep = '/--/';
	$sqlAlumnos = traerSql('*','alumno');
	while($rowAlumnos = pg_fetch_array($sqlAlumnos))
	{
		$dataAlumno = $rowAlumnos['dni'].$sep.$rowAlumnos['apellido'].$sep.$rowAlumnos['nombre'].$sep.$rowAlumnos['fecha_nac'].$sep.$rowAlumnos['mail'].$sep.$rowAlumnos['id'];
		echo "<script>setAlumno('".$dataAlumno."')</script>";
	}
}

/*
$verificarMail=traerSql('mail', 'pasante');
while($rowVerifMail=pg_fetch_array($verificarMail,NULL,PGSQL_ASSOC)){
	echo "<script>setMail('".$rowVerifMail['mail']."')</script>";
}
*/
?>
<div id="formulario">
<h2>Registrar nueva visita</h2>
<form class="formNuevaVisita" name="f1" id="form2" action="guardarNuevaVisita.php" method="post">
<table align="center" width="100%">
	<tr width="100%">
		<td width="100%">
			<fieldset>
				<legend>Datos de la visita</legend>
					<label for="nombreVisita">Nombre: </label>
					<input type="text" name="nombreVisita" id="nombreVisita" />
					<label for="fechaVisita">Fecha: </label>
					<input type="date" name="fechaVisita" id="fechaVisita" />
					<label for="catedra">C&aacute;tedra:</label>
					<input type="text" name="catedra" id="catedra" />
					<label for="profesorCatedra">Profesor a cargo de la c&aacute;tedra:</label>
					<input type="text" name="profesorCatedra" id="profesorCatedra" />
					<label for="profesorVisita">Profesor a cargo de la visita:</label>
					<input type="text" name="profesorVisita" id="profesorVisita" />
					<label for="movilidad">Medio de movilidad:</label>
					<input type="text" name="movilidad" id="movilidad" />
					<label for="motivo">Motivo de la visita:</label>
					<textarea name="motivo" id="motivo"></textarea>
			</fieldset>
			<fieldset>
				<legend>Datos de la Empresa</legend>
					<label for="nombreEmpresa">Nombre de la empresa:</label>
					<input type="text" name="nombreEmpresa" id="nombreEmpresa" />
					<label for="areaEmpresa">&Aacute;rea de la empresa:</label>
					<input type="text" name="areaEmpresa" id="areaEmpresa" />
					<label for="caracteristicaEmpresa">T&eacute;lefono:</label>
					<input type="text" name="caracteristicaEmpresa" id="caracteristicaEmpresa" />
					<input type="text" name="telefonoEmpresa" id="telefonoEmpresa" />
			</fieldset>
			<fieldset>
				<legend>Datos del Contacto</legend>
					<label for="nombreContacto">Nombre:</label>
					<input type="text" name="nombreContacto" id="nombreContacto" />
					<label for="apellidoContacto">Apellido:</label>
					<input type="text" name="apellidoContacto" id="apellidoContacto" />
					<label for="cargoContacto">Cargo que ocupa:</label>
					<input type="text" name="cargoContacto" id="cargoContacto" />
					<label for="mailContacto">Mail:</label>
					<input type="mail" name="mailContacto" id="mailContacto" />
			</fieldset>
			<fieldset>
				<legend>Alumnos</legend>
					<label for="dniAlumno">DNI: </label>
					<input type="text" name="dniAlumno" id="dniAlumno" onblur="checkAlumno()"/>
					<input type="hidden" name="idHiddenAlumno" id="idHiddenAlumno"/>
					<label for="nombreAlumno">Nombre:</label>
					<input type="text" name="nombreAlumno" id="nombreAlumno" />
					<label for="apellidoAlumno">Apellido:</label>
					<input type="text" name="apellidoAlumno" id="apellidoAlumno" />
					<label for="fechaAlumno">Fecha de Nacimiento:</label>
					<input type="text" name="fechaAlumno" id="fechaAlumno" />
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