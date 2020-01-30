<?php
session_start();
require_once("js/clases.php");
$guardaJuego=true;
if (isset($_SESSION['fedex19']) ) {  //existe la session
	//echo "valida usuario";
	$recievedJwt=$_SESSION['fedex19'];
	//token valido
	$tokenValid = Tocken::validaToken($recievedJwt);

	if($tokenValid){  //el token es valido
		//datos de token
		$usuarioC = Tocken::datosToken($recievedJwt);
		$usuarioC = json_decode($usuarioC, true);
		//print_r($usuarioC);
		$existe=Usuarios::buscaUsuario($usuarioC['usuario']);

		if($existe['encontrado'] == "si"){ //el usuario es valido
		}else{
			$guardaJuego=false;
		}  //termina usuario
	}else{
		$guardaJuego=false;
	}// termina token
}else{
	$guardaJuego=false;
}  //termina session

$correo=$usuarioC['usuario'];
//$correo="uyepez@tvp.mx";

$response = array (
"success" => "",
"dataControl" => "",
"dataUser" => "",
"error_msg" => ""
);

if($guardaJuego){
	//encripta data control con md5
	$dataControl = $correo."_entergameFedex";
	$dataControl = md5($dataControl);
	$response["dataControl"]=$dataControl;

	//encripta correo
	$correo=base64_encode($correo);
	$response["dataUser"]=$correo;

	$response["success"]="ok";

}else{
	$response["dataControl"]="false";
	$response["success"]="0";
}

echo json_encode($response);
?>
