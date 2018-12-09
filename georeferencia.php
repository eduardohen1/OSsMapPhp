<?php
  require_once('funcoes.php');
?>
<!DOCTYPE>
<html lang="pt-br">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Contet-Type" content="text/html; charset=UTF-8" /> <!-- Meta para responsibilidade -->
	<meta name="viewport" content="width=device-width" /><!-- Meta para responsibilidade -->
	<title>OSsMap - Sistema de Ordens de Servi&ccedil;os</title>

	<link rel="shortcut icon" href="images/OSsMap.ico" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/sweetalert2.css">
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/sweetalert2.js"></script>  
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>

  <!-- https://goo.gl/OOhYW5 -->
  <link rel="manifest" href="manifest.json">

  <!-- https://goo.gl/qRE0vM -->
  <meta name="theme-color" content="#607fbe">

  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script> -->

	<style type="text/css">
        .well-shadow {  -webkit-box-shadow: 0 10px 6px -6px #777; -moz-box-shadow: 0 10px 6px -6px #777; box-shadow: 0 10px 6px -6px #777; }
    </style>
</head>
<?php
  ob_start();
  session_start();

  $vvNomeUsuario     = $_SESSION['nomeUsuario'];
	$vvTipoUsuario     = $_SESSION['tipoUsuario'];
  $vvMensagem        = $_SESSION['mensagem'];
  $conn              = "";
  $conexaoSysCliente = "";

?>
<body style="padding: 50px 0; background-color: #607fbe;">
	<?php		
		$vvMensagem = "<strong>".$vvMensagem."</strong><br />Rotinas de suporte para gerenciamento do Sistema de Gest&atilde;o Comercial."		
	?>
	<div class="container">
	
      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="principal.php"><img src="images/OSsMap_p.png" alt="" class="img-responsive" height="30px" width="30px" /></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rotinas de trabalho<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php
                    if($vvTipoUsuario == 1){
                      echo("<li><a href='cados.php'>Cadastrar nova Ordem de Servi&ccedil;o</a></li>");
                      echo("<li role='separator' class='divider'></li>");
                    }
                  ?>
                  <li><a href="principal.php">Ordens de Servi&ccedil;o - Executar</a></li>
                  <li><a href="principalexec.php">Ordens de Servi&ccedil;o - Executadas</a></li>                  
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relat&oacute;rios<span class="caret"></span></a>
                <ul class="dropdown-menu">                  
                </ul>
              </li>
			  <?php			  
			  	echo ("<li class='active'><a href='georeferencia.php'>Georefer&ecirc;ncia</a></li>");
				  echo ("<li ><a href='configuracoes.php'>Configura&ccedil;&otilde;es</a></li>");			  
			  ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo($vvNomeUsuario); ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php
                    echo("<li><a href='altSenha.php'>Alterar senha</a></li>");
						        echo("<li role='separator' class='divider'></li>");
				  	        if($vvTipoUsuario == 1){
                      echo("<li><a href='cadusuario.php'>Cadastrar usu&aacute;rios</a></li>");
                      echo("<li role='separator' class='divider'></li>");
                    }
                  ?>
				          <li><a href="logout.php">Sair do sistema</a></li>                  
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h2>Georeferencia</h2>
        <p>&nbsp;</p>

        <div>
          <iframe class="embed-responsive-item" src="http://ehsolucoes.dyndns-at-home.com:8601/geoserver/minasgerais/wms?service=WMS&version=1.1.0&request=GetMap&layers=minasgerais:BRMUE250GC_SIR&styles=&bbox=-73.99044996899995,-33.751177994239676,-28.835907628999962,5.271841077172965&width=768&height=663&srs=EPSG:4674&format=application/openlayers" allowfullscreen>
          </iframe>
        </div>
		  </div>
  </div> <!-- /container -->
  
</body>
</html>