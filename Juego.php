<?php
session_start();
require_once("js/clases.php");
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
			session_destroy();
			header("Location: index.html");
			exit(0);
		}  //termina usuario

	}else{
		session_destroy();
		header("Location: index.thml");
		exit(0);
	}// termina token

}else{
	session_destroy();
	header("Location: index.html");
	exit(0);
}  //termina session

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="pragma" content="no-cache"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name ="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

    <!--CSS Bootrstrap 4.3 & Arturo-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/fireworks.css">
    <!--CSS 2020-->
    <link rel="stylesheet" href="css/style-2020.css">

    <!-- favion  -->
    <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favion/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="theme-color" content="#ffffff">

    <style>

        canvas {
                  image-rendering: optimizeSpeed;
                  -webkit-interpolation-mode: nearest-neighbor;
                  -ms-touch-action: none;
                  margin: 0px;
                  padding: 0px;
                  border: 0px;
        }
        :-webkit-full-screen #canvas {
             width: 100%;
             height: 100%;
        }
        div.gm4html5_div_class
        {
          margin: 0px;
          padding: 0px;
          border: 0px;
        }
        /* START - Login Dialog Box */
        div.gm4html5_login
        {
             padding: 20px;
             position: absolute;
             border: solid 2px #000000;
             background-color: #404040;
             color:#00ff00;
             border-radius: 15px;
             box-shadow: #101010 20px 20px 40px;
        }
        div.gm4html5_cancel_button
        {
             float: right;
        }
        div.gm4html5_login_button
        {
             float: left;
        }
        div.gm4html5_login_header
        {
             text-align: center;
        }
        /* END - Login Dialog Box */
        :-webkit-full-screen {
           width: 100%;
           height: 100%;
        }

        .game {
          background-color: transparent!important;
        }
    </style>

    <title>Fedex</title>
</head>

<body>
    <header>
        <!--NavBar-->
        <nav class="navbar navbar-expand-lg navbar-light " id="NavFedex">

            <img src="images/logo_fedex.png" class="img-fluid" id="Img-Logo" alt="FedEx" onclick="location.href='index.html';">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active text-white">
                        <a class="nav-link text-white" href="index.html#mecanica">Mecánica <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.html#registro">Registro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.html#premios">Premios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.html#ganadores">Ganadores</a>
                    </li>
                </ul>
                <span class="navbar-text"><a href="#" class="text-white" onclick="location.href='MiCuenta.php';">Mi Cuenta</a></span>
                <img src="images/Icon-cuenta.png" class="img-fluid" id="icon-cuenta" alt="Cuenta">
            </div>
        </nav>
    </header>
    <main>
        <div class="container-fluid gamepage">
            <div class="game">
                <!--Ventana del juego<br>-<br><a class="btn btn-primary" data-toggle="modal" data-target="#Gracias-Participar">Modal de fin del juego</a>-->



            </div>
        </div>

        <!--Modal | Numero de Guia | Se carga automaticamente al inicar la pagina y pide al usuario el no. de guía-->
        <div class="modal" id="LoadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-backdrop">
                    </div>
                    <div class="modal-body" id="Modal">
                        <div class="row center">
                            <img class="img-fluid ImgModal" src="images/ModalJuego.png" alt="Modal Image">
                        </div>
                        <div class="row">
                            <div class="col-12 textcenter">
                                <h2 class="TitulosModal">¡El mejor goleador!</h2>
                                <p class="ModalText">Registra tu No. de Guía y comienza el juego. Acumula puntos por cada guía registrada.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <form class="" action="" method="post" onsubmit="validador()">
                                    <input class="textcenter" id="NoGuia" type="text" name="NoGuia" value="" size="12" maxlength="12" placeholder="Escriba su No. de guía FedEx">
                                </form>
                            </div>
                        </div>
                        <div class="row" id="error">
                            <div class="col-12 textcenter">
                                <p>Número de guía incorrecto o registrado anteriormente</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                              <div id="alertaRegistro" class="textcenter error">
                                asdas
                              </div>
                                <button type="button" class="btn btn-primary btn-lg maxwidth EndPage" onclick="validador()">Participar</button>
                            </div>
                        </div>

                    </div>
                    <div class="container-fluid center align" id="CountDown">
                        <div class="row">
                            <div class="col-12 align">
                                <p id="countdown"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Modal | Gracias por Participar-->
        <div class="modal fade" id="Gracias-Participar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-game">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="location.href='MiCuenta.html';">
                <span aria-hidden="true">&times;</span>
              </button>
                    </div>
                    <div class="modal-body centerWrap">
                        <div class="row center">
                            <img class="img-fluid iconothanks fadeInUp animated" src="images/thanks.png" alt="Thanks">
                        </div>
                        <div class="row center marginTop">
                            <h6>Gracias por participar</h6>
                        </div>
                    </div>
                    <div class="modal-footer center">
                        <button type="button" class="btn btn-primary btn-lg" onclick="location.href='MiCuenta.html';">Ir a Mi Cuenta</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bottom">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3 center linea">
                    <h4><a href="PDF/TC-FedEx.pdf" target="_blank">Términos y Condiciones de uso</a></h4>
                </div>
                <div class="col-12 col-md-3 center linea">
                    <h4><a href="PDF/AvisoPrivacidad.pdf" target="_blank">Aviso de Privacidad</a></h4>
                </div>
                <div class="col-12 col-md-3 center linea">
                    <h4><a href="https://www.fedex.com/es-mx/privacy-policy.html" target="_blank">Declaración de Privacidad</a></h4>
                </div>
                <div class="col-12 col-md-3 center linea">
                    <h4><a href="PDF/FAQs.pdf" target="_blank">FAQs</a></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 center">
                    <p class="textFooter">TVP. Este sitio utiliza cookies para ayudarnos a mejorar tu experiencia cada vez que lo visites. Al continuar navegando en el, estarás aceptando su uso. Podrás deshabilitarlas accediendo a la configuración de tu navegador.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts Bootstrap 4.3, AOS Library & Arturo -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="js/aos.js"></script>
    <script type="text/javascript" src="js/validacion.js"></script>
    <script>
        AOS.init({
            easing: 'ease-in-out-sine'
        });
    </script>



</body>

</html>
