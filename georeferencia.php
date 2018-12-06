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
  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
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
        <p>
        <p id="demo">Clique no botão para obter sua localização:</p>
        <button onclick="getLocation()">Clique aqui</button>
         <div id="mapholder"></div>
        </p>
		  </div>
    </div> <!-- /container -->

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">  
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Liga&ccedil;&atilde;o nova 00155.2018-2</h4>
		  </div>
		  <div class="modal-body">
      <img src="images/mapa02.png" alt="" class="img-responsive" />
		  </div>
		  <div class="modal-footer">		  	
			<button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Fechar</button>			
		  </div>
		</div>
	  </div>
	</div>

  <script type="text/javascript">
		$('#myModal').on('shown.bs.modal', function () {
		  //$("#lblContraChave").html(chave);
		  $('#myInput').focus();		  
    });
    
    function concluirOS(numOs, anoOs){
      Swal({
        title: 'Executar OS?',
        text: "Deseja marcar que esta OS está executada?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'N&atilde;o'
      }).then((result) => {
        if (result.value) {
          window.location.replace("concluiros.php?numos=" + numOs + "&anoos=" + anoOs);
        }
      });
    }

    function cancelarOS(numOs, anoOs){
      Swal({
        title: 'Cancelar OS?',
        text: "Deseja cancelar esta OS?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'N&atilde;o'
      }).then((result) => {
        if (result.value) {
          window.location.replace("cancelaros.php?numos=" + numOs + "&anoos=" + anoOs);
        }
      });
    }

  </script>
  <script>
var x=document.getElementById("demo");
function getLocation()
  {
  if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition,showError);
    }
  else{x.innerHTML="Geolocalização não é suportada nesse browser.";}
  }
 
function showPosition(position)
  {
  lat=position.coords.latitude;
  lon=position.coords.longitude;
  latlon=new google.maps.LatLng(lat, lon)
  mapholder=document.getElementById('mapholder')
  mapholder.style.height='250px';
  mapholder.style.width='500px';
 
  var myOptions={
  center:latlon,zoom:14,
  mapTypeId:google.maps.MapTypeId.ROADMAP,
  mapTypeControl:false,
  navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
  };
  var map=new google.maps.Map(document.getElementById("mapholder"),myOptions);
  var marker=new google.maps.Marker({position:latlon,map:map,title:"Você está Aqui!"});
  }
 
function showError(error)
  {
  switch(error.code)
    {
    case error.PERMISSION_DENIED:
      x.innerHTML="Usuário rejeitou a solicitação de Geolocalização."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML="Localização indisponível."
      break;
    case error.TIMEOUT:
      x.innerHTML="O tempo da requisição expirou."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML="Algum erro desconhecido aconteceu."
      break;
    }
  }
</script>
</body>
</html>