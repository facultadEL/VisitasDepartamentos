<?php

include_once "conexion.php";
include_once "scripts/libreria.php";

$idVisita = (empty($_REQUEST['idVisitaHidden'])) ? 0 : $_REQUEST['idVisitaHidden'];

if($idVisita == 0) //Crea una nueva visita
{
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
	$mailContacto = (empty($_REQUEST['mailContacto'])) ? 0 : $_REQUEST['mailContacto'];

	$datosAlumnos = (empty($_REQUEST['datosAlumnos'])) ? 0 : $_REQUEST['datosAlumnos'];

	if()//Aca se controla nuevamente los datos obligatorios
	{
		$idNuevaVisita = traerProximoId('visita');
		$sqlNuevaVisita = "INSERT INTO visita(id,nombre,) VALUES()";

		//Veo que usuario ya hay creados segun el id

		//Creo los usuarios nuevos faltantes

		//Creo la tabla intermedia con todos los ids de los usuarios

	}

}
else //Actualiza una visita existente
{

}

?>