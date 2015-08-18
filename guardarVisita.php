<?php
session_start();
include_once "conexion.php";
include_once "scripts/libreria.php";

$idVisita = (empty($_REQUEST['idVisitaHidden'])) ? 0 : $_REQUEST['idVisitaHidden'];

$nombreVisita = (empty($_REQUEST['nombreVisita'])) ? 0 : $_REQUEST['nombreVisita'];
$fechaVisita = (empty($_REQUEST['fechaVisita'])) ? 0 : $_REQUEST['fechaVisita'];
$catedra = (empty($_REQUEST['catedra'])) ? 0 : $_REQUEST['catedra'];
$profesorCatedra = (empty($_REQUEST['profesorCatedra'])) ? 0 : $_REQUEST['profesorCatedra'];
$profesorVisita = (empty($_REQUEST['profesorVisita'])) ? $profesorCatedra : $_REQUEST['profesorVisita'];
$movilidad = (empty($_REQUEST['movilidad'])) ? 0 : $_REQUEST['movilidad'];
$motivo = (empty($_REQUEST['motivo'])) ? 0 : $_REQUEST['motivo'];
$nombreEmpresa = (empty($_REQUEST['nombreEmpresa'])) ? 0 : $_REQUEST['nombreEmpresa'];
$areaEmpresa = (empty($_REQUEST['areaEmpresa'])) ? 0 : $_REQUEST['areaEmpresa'];
$caracteristicaEmpresa = (empty($_REQUEST['caracteristicaEmpresa'])) ? 0 : $_REQUEST['caracteristicaEmpresa'];
$telefonoEmpresa = (empty($_REQUEST['telefonoEmpresa'])) ? 0 : $_REQUEST['telefonoEmpresa'];
$nombreContacto = (empty($_REQUEST['nombreContacto'])) ? 0 : $_REQUEST['nombreContacto'];
$apellidoContacto = (empty($_REQUEST['apellidoContacto'])) ? 0 : $_REQUEST['apellidoContacto'];
$cargoContacto = (empty($_REQUEST['cargoContacto'])) ? 0 : $_REQUEST['cargoContacto'];
$mailContacto = (empty($_REQUEST['mailContacto'])) ? 'null' : $_REQUEST['mailContacto'];

$datosAlumnos = (empty($_REQUEST['datosAlumnos'])) ? 0 : $_REQUEST['datosAlumnos'];

$telefonoEmpresaCompleto = $caracteristicaEmpresa.'-'.$telefonoEmpresa;

if($idVisita == 0) //Crea una nueva visita
{
	if(0 == 0)//Aca se controla nuevamente los datos obligatorios
	{
		
		$idNuevaVisita = traerProximoId('visita');
		$solicitante = $_SESSION['id_user'];
		$sqlNuevaVisita = "INSERT INTO visita(id,nombre,catedra,profesor_catedra,profesor_visita,movilidad,fecha,motivo_visita,nombre_empresa,area_empresa,telefono_empresa,nombre_contacto,apellido_contacto,cargo_contacto,mail_contacto,solicitante_fk) VALUES($idNuevaVisita,'$nombreVisita','$catedra','$profesorCatedra','$profesorVisita','$movilidad','$fechaVisita','$motivo','$nombreEmpresa','$areaEmpresa','$telefonoEmpresaCompleto','$nombreContacto','$apellidoContacto','$cargoContacto','$mailContacto',$solicitante);";
		//echo $sqlNuevaVisita.'<br>';
		//echo $datosAlumnos.'<br>';

		//Veo que usuario ya hay creados segun el id
		$sqlNuevosAlumnos = "";
		$idTablaIntermedia = "";
		$vDatosAlumno = explode('/-/-/', $datosAlumnos);
		$idUltimoAlumno = traerUltimo('alumno');
		for($i = 0;$i < count($vDatosAlumno); $i++)
		{
			//echo $vDatosAlumno[$i];
			$vAlumno = explode('/--/',$vDatosAlumno[$i]);
			if($vAlumno[5] == '-1')
			{
				$idUltimoAlumno++;
				$sqlNuevosAlumnos .= "INSERT INTO alumno(id,apellido,nombre,tipodni_fk,dni,fecha_nac,mail) VALUES($idUltimoAlumno,'$vAlumno[1]','$vAlumno[2]',1,'$vAlumno[0]','$vAlumno[3]','$vAlumno[4]');";

				$idTablaIntermedia .= $idUltimoAlumno;
				if($i < (count($vDatosAlumno) - 1))
				{
					$idTablaIntermedia .= '/-/';
				}
				
			}
			else
			{
				$sqlNuevosAlumnos .= "UPDATE alumno SET apellido='$vAlumno[1]',nombre='$vAlumno[2]',dni='$vAlumno[0]',fecha_nac='$vAlumno[3]',mail='$vAlumno[4]' WHERE id=$vAlumno[5];";
				$idTablaIntermedia .= $vAlumno[5];
				if($i < (count($vDatosAlumno) - 1))
				{
					$idTablaIntermedia .= '/-/';
				}
			}
		}

		//Creo los usuarios nuevos faltantes

		//Creo la tabla intermedia con todos los ids de los usuarios
		$sqlTablaIntermedia = "DELETE FROM alumnoxvisita WHERE visita_fk=$idNuevaVisita;";
		$vDatosTablaIntermedia = explode('/-/', $idTablaIntermedia);
		$idAlumnoXVisita = traerUltimo('alumnoxvisita');
		for($i = 0;$i < count($vDatosTablaIntermedia);$i++)
		{
			$idAlumnoXVisita++;
			$sqlTablaIntermedia .= "INSERT INTO alumnoxvisita(id,alumno_fk,visita_fk) VALUES($idAlumnoXVisita,'$vDatosTablaIntermedia[$i]',$idNuevaVisita);";
		}

		$consultaCompleta = $sqlNuevaVisita.$sqlNuevosAlumnos.$sqlTablaIntermedia;
		//echo $consultaCompleta;
		/*
		$cuerpo = "
	        <div align='left'>
	            <div align='left'>
	            ¡Hola <strong>".$nombre."</strong>!<br/><br/>
				
				<strong>Te has inscripto correctamente a las Jornadas para PyMEs de la UTN</strong>, que se llevarán a cabo los días miércoles 3 y jueves 4 de junio de 2015 a partir de las 14:00 hs. 
				en la UTN de Villa María.<br/><br/>

				Te invitamos a conocer la agenda del evento y todos los detalles en <a href=".'"www.jornadaspymesutn.com.ar"'.">www.jornadaspymesutn.com.ar</a> <br/><br/>

				Recuerda asistir con tu DNI para que podamos entregarte tú certificado.<br/>
				También te recomendamos llevar tarjetas de presentación para sacar el máximo provecho de esta oportunidad única para ponerte en contacto con otros emprendedores y empresarios.<br/><br/>

				* Por favor, en caso de no poder asistir, notifícanos con tiempo a <a href=".'"mailto:info@jornadaspymesutn.com.ar" target="_top"'.">info@jornadaspymesutn.com.ar</a><br/><br/>

				<strong>¡Te esperamos!</strong>

	            </div>
	        </div>
	        ";
	        $asunto = 'Visita registrada por '.$_SESSION['nombre'];
	        $sendFrom = "extension@frvm.utn.edu.ar";
	        $from_name = "Sistema de Registro de Visitas";
	        $to = 'extension@frvm.utn.edu.ar';
		do
		{
			
			$enviado = enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to);
		}while(!$enviado)
		*/
	}
	else
	{
		mostrarMensaje('Se encontro un error al leer los datos','registrarVisita.php');
	}

}
else //Actualiza una visita existente
{
	$sqlUpdateVisita = "UPDATE visita SET nombre='$nombreVisita',catedra='$catedra',profesor_catedra='$profesorCatedra',profesor_visita='$profesorVisita',movilidad='$movilidad',fecha='$fechaVisita',motivo_visita='$motivo',nombre_empresa='$nombreEmpresa',area_empresa='$areaEmpresa',telefono_empresa='$telefonoEmpresaCompleto',nombre_contacto='$nombreContacto',apellido_contacto='$apellidoContacto',cargo_contacto='$cargoContacto',mail_contacto='$mailContacto' WHERE id=$idVisita;";

	//Veo que usuario ya hay creados segun el id
	$sqlNuevosAlumnos = "";
	$idTablaIntermedia = "";
	$vDatosAlumno = explode('/-/-/', $datosAlumnos);
	$idUltimoAlumno = traerUltimo('alumno');
	for($i = 0;$i < count($vDatosAlumno); $i++)
	{
		//echo $vDatosAlumno[$i];
		$vAlumno = explode('/--/',$vDatosAlumno[$i]);
		if($vAlumno[5] == '-1')
		{
			$idUltimoAlumno++;
			$sqlNuevosAlumnos .= "INSERT INTO alumno(id,apellido,nombre,tipodni_fk,dni,fecha_nac,mail) VALUES($idUltimoAlumno,'$vAlumno[1]','$vAlumno[2]',1,'$vAlumno[0]','$vAlumno[3]','$vAlumno[4]');";

			$idTablaIntermedia .= $idUltimoAlumno;
			if($i < (count($vDatosAlumno) - 1))
			{
				$idTablaIntermedia .= '/-/';
			}
			
		}
		else
		{
			$sqlNuevosAlumnos .= "UPDATE alumno SET apellido='$vAlumno[1]',nombre='$vAlumno[2]',dni='$vAlumno[0]',fecha_nac='$vAlumno[3]',mail='$vAlumno[4]' WHERE id=$vAlumno[5];";
			$idTablaIntermedia .= $vAlumno[5];
			if($i < (count($vDatosAlumno) - 1))
			{
				$idTablaIntermedia .= '/-/';
			}
		}
	}

	//Creo la tabla intermedia con todos los ids de los usuarios
	$sqlTablaIntermedia = "DELETE from alumnoxvisita WHERE visita_fk=$idVisita;";
	$vDatosTablaIntermedia = explode('/-/', $idTablaIntermedia);
	$idAlumnoXVisita = traerUltimo('alumnoxvisita');
	for($i = 0;$i < count($vDatosTablaIntermedia);$i++)
	{
		$idAlumnoXVisita++;
		$sqlTablaIntermedia .= "INSERT INTO alumnoxvisita(id,alumno_fk,visita_fk) VALUES($idAlumnoXVisita,'$vDatosTablaIntermedia[$i]',$idVisita);";
	}

	$consultaCompleta = $sqlUpdateVisita.$sqlNuevosAlumnos.$sqlTablaIntermedia;
}

if($consultaCompleta != '')
{
	echo $consultaCompleta;
	$error = guardarSql($consultaCompleta);
	if($error == 1)
	{
		mostrarMensaje('Los datos no se pudieron guardar correctamente','registrarVisita.php');
	}
	else
	{
		mostrarMensaje('Los datos se han guardado correctamente','escritorioVisitas.php');
	}
}

include_once "cerrar_conexion.php";

?>