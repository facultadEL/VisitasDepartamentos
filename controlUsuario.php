<?php

//Control usuario va a devolver una serie de numeros que representan exito o errores
/*
0 - Usuario no encontrado
1 - Usuario y contraseña encontrados correctamente
2 - Contraseña incorrecta
3 - Usuario deshabilitado
*/

include_once "conexion.php";
//include_once "scripts/libreria.php";

//$conn = pg_connect("host=localhost port=5432 user=postgres password=postgres dbname=visitasDepto") or die("Error de conexion.".pg_last_error());

$userToValidate = $_POST["user"];
$passToValidate = $_POST["pass"];

$control = 0;

$sql = pg_query("SELECT * FROM usuario where UPPER(username) like UPPER('{$userToValidate}') ORDER BY id");
//$sql = traerSql('*','usuario ORDER BY id');
while($rowSql = pg_fetch_array($sql))
{
	$usuarioDB = strtolower($rowSql['username']);
	if($userToValidate == $usuarioDB)
	{
		if($rowSql['habilitado'] == true)
		{
			if(md5($passToValidate) == $rowSql['pass'])
			{
				echo '1';
				break;
			}
			else
			{
				echo '2';
				break;
			}	
		}
		else
		{
			echo '3';
			break;
		}
	}
	else
	{
		echo '2';
		break;
	}
}

include_once "cerrar_conexion.php";
?>