<!DOCTYPE>
<html lang="pt-br">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Contet-Type" content="text/html; charset=UTF-8" /> <!-- Meta para responsibilidade -->
	<meta name="viewport" content="width=device-width" /><!-- Meta para responsibilidade -->
	<title>OSsMap - Sistema de Ordens de Servi&ccedil;os</title>

	<link rel="shortcut icon" href="http://autoatendimento.prosanearinfo.com.br/exec/testeOSsMap/images/OSsMap.ico" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<style type="text/css">
        .well-shadow {  -webkit-box-shadow: 0 10px 6px -6px #777; -moz-box-shadow: 0 10px 6px -6px #777; box-shadow: 0 10px 6px -6px #777; }
    </style>
</head>
<body style="padding: 50px 0;">	
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
              <li class="dropdown active">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rotinas de trabalho<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="diagnostico.php">Ordens de Servi&ccedil;o - Executar</a></li>
                  <li><a href="diagnostico.php">Ordens de Servi&ccedil;o - Executadas</a></li>                  
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relat&oacute;rios<span class="caret"></span></a>
                <ul class="dropdown-menu">                  
                </ul>
              </li>
			  <?php			  
			  	echo ("<li ><a href='diagnosticoClientes.php'>Georefer&ecirc;ncia</a></li>");
				  echo ("<li ><a href='configuracoes.php'>Configura&ccedil;&otilde;es</a></li>");			  
			  ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo("Administrador"); ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php
				  	if($vvTipoUsuario != 0){
						echo("<li><a href='altSenha.php'>Alterar senha</a></li>");
						echo("<li role='separator' class='divider'></li>");
					}
				  ?>
				  <li><a href="logout.php">Sair do sistema</a></li>
                  <!--<li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>-->
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h2>Ordens de Servi&ccedil;o - Executar</h2>
        <p>&nbsp;</p>
        <p>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="text-center col-md-4">Servi&ccedil;o</th>
                  <th class="text-center col-md-3">Solicitante</th>
                  <th class="text-center col-md-2">Dt solicita&ccedil;&atilde;o</th>
                  <th class="text-center col-md-1">Executar</th>                  
                  <th class="text-center col-md-1">Geo</th>
                  <th class="text-center col-md-1">Cancelar</th>
                </tr>
              </thead>
              <tbody id='tbListaUsuario'>
                <tr>
                  <td>Liga&ccedil;&atilde;o nova 00155.2018-2</td>
                  <td>Nononononono</td>
                  <td class="text-center">15/11/2018</td>
                  <td class="text-center"><a href='#' class='btn btn-success'><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a></td>
                  <td class="text-center"><a href='#' class='btn btn-info' data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></a></td>
                  <td class="text-center"><a href='#' class='btn btn-danger'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
                </tr>
                <tr>
                  <td>Vazamento 02020.2018-X</td>
                  <td>Fulando Beltrano Junior</td>
                  <td class="text-center">20/11/2018</td>
                  <td class="text-center"><a href='#' class='btn btn-success'><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a></td>
                  <td class="text-center"><a href='#' class='btn btn-info'><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></a></td>
                  <td class="text-center"><a href='#' class='btn btn-danger'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
                </tr>
                <tr>
                  <td>Liga&ccedil;&atilde;o nova 00156.2018-8</td>
                  <td>Maria Teste Beltrano</td>
                  <td class="text-center">12/11/2018</td>
                  <td class="text-center"><a href='#' class='btn btn-success'><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a></td>
                  <td class="text-center"><a href='#' class='btn btn-info'><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></a></td>
                  <td class="text-center"><a href='#' class='btn btn-danger'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
                </tr>
              </tbody>
            </table>
          </div>
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
  </script>
</body>
</html>