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
$guia=$usuarioC['guia'];
$valid = true;


$dataCheck="";
$dataUser=$_POST['dataUser'];
$estatus=$_POST['dataControl'];
$puntos=$_POST['dataPuntos'];


$dataUser=base64_decode($dataUser);
$puntos=base64_decode($puntos);

//$termino=base64_decode($termino);


$dataCheck=$dataUser."_gameOverFedex".$puntos;
//$dataCheck = "uyepez@tvpromo.com.mx_gameOver6_33";
//$sesuser['correo'] = "uyepez@tvpromo.com.mx";
$dataCheck = md5($dataCheck);


$data = array();
//zona horarios de mexico
date_default_timezone_set('America/Mexico_City');
$fechad=date("Y-m-d H:i:s");
$hoy=date("Y-m-d");
$semana = date("W");
$origen = "web";
$data['guia']=$guia;

$response = array (
"success" => 0,
"error_msg" => ""
);


if (!filter_var($usuarioC['usuario'], FILTER_VALIDATE_EMAIL)) {
  $valid=false;
}


if (!preg_match('/^[0-9]{12,12}$/', $data['guia'])) {
  $response["error_msg"].= 'Solo números para el numero de guia. ';
  $valid = false;
}


$existe=Guias::buscaGuia($data['guia']);
if($existe['encontrado']=="si"){
  //ya existe el usuario
  $response["error_msg"]="Guia ya registrada";
}else{
  if($dataCheck==$estatus){
    if($valid && $puntos && $guia){
      //juegos guardados del ticket
      $response["success"]="ok";
      $data['fecha']=$fechad;
  		$data['hoy']=$hoy;
  		$data['semana']=$semana;
  		$data['ip']=$_SERVER['REMOTE_ADDR'];

      $data['usuario']=$usuarioC['usuario'];


      $data['cajas']=$puntos;
      $data['dia']=$hoy;
      //guarda juego
      Guias::regGuia($data);

      $resultado=array("usuario"=>$usuarioC['usuario'],"promo"=>"fedex19");
      $ses = Tocken::nuevoToken(json_encode($resultado));
      $_SESSION['fedex19']=$ses;

    }
  }else{
    $response["error_msg"]="incorrecto";
  }
}

echo json_encode($response);
?>
