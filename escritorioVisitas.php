<?php
	session_start();

	include_once "chekearLogin.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!--script type='text/javascript' src="scripts/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="css/escritorioVisitas.css"-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
<link rel="stylesheet" href="bootstrap/css/estilos.css">
<script src="bootstrap/js/jquery-1.11.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
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
		$('#noVisitas').show();
	}
	else
	{
		$('#noVisitas').hide();
	}
	//$('#nuevaVisita').accordion({collapsible: true, active: false, header: "h3", icons: false});
});


</script>
</head>

<?php
include_once "conexion.php";
include_once "scripts/libreria.php";

$condicion = 'solicitante_fk='.$_SESSION['id_user'];
$cantVisitas = contarRegistro('id','visita',$condicion);
echo "<script>setCantVisitas('".$cantVisitas."')</script>";

?>
<body>
<div class="container">
		<div class="margen_sup"></div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Listado de visitas</h2>
			</div>
		</div>

		<ul class="nav nav-pills" style="background-color: #EEEEEE;">
			<li class="active"><a href="#">Visitas</a></li>
			<li><a href="registrarVisita.php">Registrar Visita</a></li>
			<li><a href="login.php">Cerrar Sesi&oacute;n</a></li>
		</ul>

		<div class="row" id="listadoVisitas">
			<div class="col-xs-12">
				<table class="table table-responsive table-striped">
					<thead>
					<tr>
						<th class="col-xs-3">
							Nombre
						</th>
						<th class="col-xs-2">
							Fecha
						</th>
						<th class="col-xs-4">
							C&aacute;tedra
						</th>
						<th class="col-xs-2">
							Empresa
						</th>
						<th class="col-xs-1">
							&nbsp;
						</th>
					</tr>
					</thead>
					<tbody>
						<?php

						$condicion = "solicitante_fk=".$_SESSION['id_user'];
						$sqlListadoVisitas = traerSqlCondicion('*','visita',$condicion);
						while($rowListadoVisitas = pg_fetch_array($sqlListadoVisitas))
						{
							$vFecha = explode('-', $rowListadoVisitas['fecha']);
							$fecha = $vFecha[2].'-'.$vFecha[1].'-'.$vFecha[0];
							echo '<tr>';
								echo '<td class="col-xs-3">';
									echo $rowListadoVisitas['nombre'];
								echo '</td>';
								echo '<td class="col-xs-2">';
									echo $fecha;
								echo '</td>';
								echo '<td class="col-xs-4">';
									echo $rowListadoVisitas['catedra'];
								echo '</td>';
								echo '<td class="col-xs-2">';
									echo $rowListadoVisitas['nombre_empresa'];
								echo '</td>';
								echo '<td class="col-xs-1">';
									echo '<a href="registrarVisita.php?idVisita='.$rowListadoVisitas['id'].'">Ver m&aacute;s</a>';
								echo '</td>';
							echo '</tr>';
						}

						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row" id="noVisitas">
			<div class="col-xs-12">
				<table class="table">
					<thead>
					<tr>
						<th class="col-xs-12">
							Listado de visitas
						</th>
					</tr>
					</thead>
					<tbody>
						<td class="col-xs-12">
							No hay visitas registradas
						</td>
					</tbody>
				</table>
			</div>
		</div>

</div>
</body>
<?php
include_once "cerrar_conexion.php";
 ?>
</html>