<?php

//Control usuario va a devolver una serie de numeros que representan exito o errores
/*
0 - Usuario no encontrado
1 - Usuario y contraseña encontrados correctamente
2 - Contraseña incorrecta
3 - Usuario deshabilitado
*/

include_once "conexion.php";
include_once "scripts/libreria.php";

$userToValidate = $_POST["user"];
$passToValidate = $_POST["pass"];

$sql = traerSql('*','usuario ORDER BY id');
while($rowSql = pg_fetch_array($sql))
{
	$usuarioDB = $rowSql['user'];
	if($userToValidate == $usuarioDB)
	{
		if($rowSql['habilitado'] == true)
		{
			if(md5(crypt($passToValidate,CRYPT_BLOWFISH)) == $rowSql['password'])
			{
				return 1;
			}
			else
			{
				return 2;
			}	
		}
		else
		{
			return 3;
		}
	}
}
return 0;

include_once "cerrar_conexion.php";
?>