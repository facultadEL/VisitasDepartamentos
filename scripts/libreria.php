<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<script type='text/javascript' src="codeLibrary.js"></script>
<?php
//Actualizada a la fecha 30/09/2014 
//error_reporting(E_ALL & ~E_NOTICE);
//Guarda la consulta de base de datos, siempre y cuando se le envie el sql y la conexion a la base;
    //Devuelve el error para hacer el javascript para mostrar los mensajes segun el guardado
function guardarSql($sqlGuardar){
    $error = 0;
    if(!pg_query($sqlGuardar)){
        $termino = "ROLLBACK";
        $error = 1;
    }else{
        $termino = "COMMIT";
    }
    
    pg_query($termino);
    
    return $error;
}

function setDate($f){
    $vF = explode('-', $f);
    return $vF[2].'/'.$vF[1].'/'.$vF[0];
}

function contarRegistro($columna,$tabla,$condicion){
    if($condicion==NULL){
        $sqlContar = pg_query("SELECT count($columna)".' AS "contar"'." FROM ".$tabla);
    }else{
        $sqlContar = pg_query("SELECT count($columna)".' AS "contar"'." FROM $tabla WHERE ".$condicion);
    }
    $rowContar = pg_fetch_array($sqlContar);
    return $rowContar['contar'];
}

function traerSql($rango,$tabla){
    $sql = pg_query('SELECT '.$rango.' FROM '.$tabla);
    return $sql;
}

function traerSqlCondicion($rango,$tabla,$condicion){
    $sql = pg_query('SELECT '.$rango.' FROM '.$tabla.' WHERE '.$condicion);
    return $sql;
}

function traerProximoId($tabla){
	$sqlId = pg_query('SELECT max(id) FROM '.$tabla);
	$rowId = pg_fetch_array($sqlId);
	$maxId = $rowId['max'] + 1;
	return $maxId;
}
function traerUltimo($tabla){
    $sqlId = pg_query('SELECT max(id) FROM '.$tabla);
    $rowId = pg_fetch_array($sqlId);
    $maxId = $rowId['max'];
    return $maxId;
}


//Muestra el mensaje javascript y redirecciona a los lugares que le mandemos
function mostrarMensaje($msg,$redireccion){
    echo '<script type="text/javascript">alert("'.$msg.'")
        location.href="'.$redireccion.'"
        </script>';
}

//Muestra la diferencia de dias entre dos fechas
function diasRestantes($f){
        //if ((ano % 4 == 0) && ((ano % 100 != 0) || (ano % 400 == 0))
        $diaActual = date('d');
        $mesActual = date('m');
        $anioActual = date('Y');
        $fechaActual = $anioActual.'-'.$mesActual.'-'.$diaActual;
        
        $datetime1 = date_create($fechaActual);
        $datetime2 = date_create($f);
        $interval = date_diff($datetime2, $datetime1);
        return $interval->format('%R%a días');
}

function cambiarDni($dni){
  $largoDni = strlen($dni);
  switch ($largoDni) {
    case '7':
      $dniFormateado = $dni[0].'.'.$dni[1].$dni[2].$dni[3].'.'.$dni[4].$dni[5].$dni[6];
      break;
    case 8:
      $dniFormateado = $dni[0].$dni[1].'.'.$dni[2].$dni[3].$dni[4].'.'.$dni[5].$dni[6].$dni[7];
      break;
  }
  return $dniFormateado;
}

/*
Esta funcion sube los datos al servidor.
Se le tiene que mandar:
- placeToLoad = El lugar donde debe guardar el archivo. Es el nombre de la carpeta del proyecto, tal cual como se llama en el servidor.Por ejemplo: SeguimientoTitulo, 
- fileName = La informacion obtenida de $_FILES['archivoPdf']['name'] 
- fileTmpName = La informacion obtenida de $_FILES['archivoPdf']['tmp_name'];
*/
function loadFileToServer($placeToLoad) {
    
	$nombre_archivoPdf = $_FILES['add_idea']['name'];
	$tipo_archivo = $_FILES['add_idea']['type'];
	$tamano_archivo = $_FILES['add_idea']['size'];
	$filePdf = $_FILES['add_idea']['tmp_name'];
	
	$ftp_server = "190.114.198.126";
	$ftp_user_name = "fernandoserassioextension";
	$ftp_user_pass = "fernando2013";
	$destino_Pdf = "web/".$placeToLoad."/ideas/".$nombre_archivoPdf;
	$destinoPdf = "ideas/".$nombre_archivoPdf;
	$vacio = "ideas/";
	
	//conexión
	$conn_id = ftp_connect($ftp_server); 
	// logeo
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	
    //probando conexion
    //if ((!$conn_id) || (!$login_result)){ 
    //       echo "Conexión al FTP con errores!";
    //       echo "Intentando conectar a $ftp_server for user $ftp_user_name"; 
    //       exit; 
    //   }else{
    //       echo "Conectado a $ftp_server, for user $ftp_user_name";
    //   }

    if ($nombre_archivoPdf <> NULL){
        $uploadPdf = ftp_put($conn_id, $destino_Pdf, $filePdf, FTP_BINARY);
    }
	return $destinoPdf;
}

function getCode($largoCodigo)
{
    echo '<script>sD();lDD();longValue = '.$largoCodigo.';codigo = gP(longValue);</script>';
    $variablephp = "<script> document.write(codigo) </script>";
    return $variablephp;
}


require ("PHPMailer_5.2.1/class.phpmailer.php");

// $sendFrom = dirección remitente
// $from_name = nombre remitente
// $to = dirección a donde enviamos

function enviarMail($c,$a,$sendFrom,$from_name,$to,$copia_oculta){
        
    $cuerpo = $c;
    $asunto = $a;
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl"; 
    $mail->Host = "smtp.gmail.com"; // dirección del servidor
    $mail->Username = "extensionfrvm@gmail.com"; // Usuario //VA OTRO MAIL, HAY QUE CREAR UN GMAIL CREO.

    $mail->Password = "4537500frvm"; // Contraseña

    $mail->Port = 465; // Puerto a utilizar
    $mail->From = $sendFrom; // dirección remitente
    $mail->FromName = $from_name; // nombre remitente

    $mail->AddAddress($to, ''); // Esta es la dirección a donde enviamos

    //$mail->AddCC("cuenta@dominio.com"); // Copia
    $mail->AddBCC($copia_oculta); // Copia oculta
    $mail->IsHTML(true); // El correo se envía como HTML
    $mail->Subject = $asunto; // Asunto
    $mail->Body = $cuerpo; // Mensaje a enviar
    //$mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // cuerpo alternativo del mensaje
    //$mail->AddAttachment("imagenes/imagen.jpg", "imagen.jpg");
    $exito = $mail->Send(); // Envía el correo.
    


//
//if($exito){
//	echo '<script language="JavaScript"> 
//		alert("Verifique su casilla de correo, le hemos enviado un mail.");
//		location ="enviarMail.php";
//		</script>';	
//}else{
//	echo '<script language="JavaScript"> 
//		alert("No se puedo enviar el correo, comuniquese con el administrador");
//		location ="enviarMail.php";
//		</script>';
//}

    }
    
