<?php
session_start();
$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];

echo '<meta charset="UTF-8"/>';

include_once "conexion.php";
include_once "scripts/libreria.php";

$condicion = "UPPER(mail) LIKE UPPER('{$usuario}') AND UPPER(password) LIKE UPPER('{$password}') LIMIT 1";
//$usuario_bd=pg_query("SELECT id,mail,password,rol_fk,primera_vez,habilitado FROM usuario WHERE UPPER(mail) LIKE UPPER('{$usuario}') AND UPPER(password) LIKE UPPER('{$password}') LIMIT 1");
$usuario_bd = traerSqlCondicion('id,mail,password,rol_fk,habilitado','usuario',$condicion);

$rowLogin = pg_fetch_array($usuario_bd);
$_SESSION['usuario'] = $usuario;
$_SESSION['rol'] = $rowLogin['rol_fk'];
$_SESSION['id_user'] = $rowLogin['id'];
$_SESSION['nombre'] = $rowLogin['descripcion'];

if ($_SESSION['rol_fk'] == 2) {
	echo '<script language="JavaScript"> window.location ="escritorioVisitas.php"</script>';
}

if ($_SESSION['rol_fk'] == 1) {
	echo '<script language="JavaScript"> window.location ="escritorioAdmin.php" </script>';
}
    
include_once "cerrar_conexion.php";

?>