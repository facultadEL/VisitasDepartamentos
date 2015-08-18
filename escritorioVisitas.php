<?php
	session_start();

	include_once "chekearLogin.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="scripts/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="css/escritorioVisitas.css">
<title>Escritorio Visitas</title>
<script>

var cantVisitas = 0;

function setCantVisitas(cantidad)
{
	cantVisitas = cantidad;
}

$(document).ready(function()
{
	if(cantVisitas == 0)
	{
		$('#listadoVisitas').hide();
	}
	//$('#nuevaVisita').accordion({collapsible: true, active: false, header: "h3", icons: false});
});


</script>
</head>

<?php
include_once "conexion.php";
include_once "scripts/libreria.php";

$condicion = 'solicitante_fk='.$_SESSION['id_user'];
echo $condicion;
$cantVisitas = contarRegistro('id','visita',$condicion);
echo "<script>setCantVisitas('".$cantVisitas."')</script>";

?>
<body>
<div id="formulario">
<h2>Visitas</h2>
<?php include_once "menuVisitas.html"; ?>

<div id="tablaCuerpo">
<a href="registrarVisita.php"><input type="button" name="nuevaVisita" value="Nueva Visita" /></a> <!--Puede ser un icono con un signo mas-->
<div id="listadoVisitas">
<h3>Listado de Visitas</h3>
<table>
<tr>
	<td>Nombre</td>
	<td>Fecha</td>
	<td>C&aacute;tedra</td>
	<td>Empresa</td>
	<td></td>
</tr>
<?php
$condicion = "solicitante_fk=".$_SESSION['id_user'];
$sqlListadoVisitas = traerSqlCondicion('*','visita',$condicion);
while($rowListadoVisitas = pg_fetch_array($sqlListadoVisitas))
{
	echo '<tr>';
		echo '<td>';
			echo $rowListadoVisitas['nombre'];
		echo '</td>';
		echo '<td>';
			echo $rowListadoVisitas['fecha'];
		echo '</td>';
		echo '<td>';
			echo $rowListadoVisitas['catedra'];
		echo '</td>';
		echo '<td>';
			echo $rowListadoVisitas['nombre_empresa'];
		echo '</td>';
		echo '<td>';
			echo '<a href="registrarVisita.php?idVisita='.$rowListadoVisitas['id'].'">Ver m&aacute;s</a>';
		echo '</td>';
	echo '</tr>';
}

?>
</table>
</div>
</div>
</center>
<table id="tablaBtn" align="center">
	<tr width="100%">	
		<td width="100%" align="center">
			<input id="enviar" class="submit" type="submit" value=""/>
 		</td>
	</tr>
</table>
</div>
</body>
<?php
include_once "cerrar_conexion.php";
 ?>
</html>