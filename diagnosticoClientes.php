<!DOCTYPE>
<html lang="pt-br">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Contet-Type" content="text/html; charset=UTF-8" /> <!-- Meta para responsibilidade -->
	<meta name="viewport" content="width=device-width" /><!-- Meta para responsibilidade -->
	<title>Rotinas de suporte - Sistema de Gestão Comercial</title>

	<link rel="shortcut icon" href="http://autoatendimento.prosanearinfo.com.br/imagens/Sis_Gestao_v6b.ico" />
	<link rel="stylesheet" type="text/css" href="../scripts/static/css/bootstrap.min.css">
	<script type="text/javascript" src="../scripts/static/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../scripts/static/js/bootstrap.min.js"></script>			
	<style type="text/css">
        .well-shadow {  -webkit-box-shadow: 0 10px 6px -6px #777; -moz-box-shadow: 0 10px 6px -6px #777; box-shadow: 0 10px 6px -6px #777; }
    </style>
</head>
<body style="padding: 50px 0;">	
	<?php
		ob_start();
		session_start();
		require_once('variaveis.php');
		require_once('conexao.php');
		require_once('procedures.php');	
		
		$vvIdUsuario   = $_SESSION['idUsuario'];
		$vvNomeUsuario = $_SESSION['nomeUsuario'];
		$vvTipoUsuario = $_SESSION['tipoUsuario'];
		$vvMensagem    = $_SESSION['mensagem'];
		$vvMensagem = "<strong>".$vvMensagem."</strong><br />Rotinas de suporte para gerenciamento do Sistema de Gest&atilde;o Comercial.";
		if(strlen($vvIdUsuario)==0){
			session_destroy();	
			header("location: index.php"); 
		}
		
		//Conectar ao sistema gestcom
		$conexao_gestcom = mysql_connect("192.168.1.250:3309","gestcomAdm","gestcom@123mgfpro") or die ("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;N&atilde;o foi poss&iacute;vel realizar a conex&atilde;o com o servidor GestCom(a)!<br/> - ".mysql_error()."</div>");   
	
		
	   //seleciona a banco de dados contas
		$db_gestcom = mysql_select_db("mgfinformatica",$conexao_gestcom) or die ("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;N&atilde;o foi poss&iacute;vel realizar a conex&atilde;o com o servidor GestCom(b)!<br/> - ".mysql_error()."</div>");
	
	   //busca dados de conexao
		$vSQL = "SELECT cl.*,CAST(CONCAT(LEFT(cc.CNPJ,2), cc.CodCliente, RIGHT(cc.CNPJ,2)) AS CHAR(20)) AS vCodLink, cc.NomeEmpresa, cc.Abreviacao, cc.IdCliente  FROM ClienteCadastro_Link AS cl INNER JOIN ClienteCadastro AS cc ON cl.CodCliente = cc.CodCliente ORDER BY cc.IdCliente";	
		
		$vResult = mysql_query($vSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar cliente!<br/> - ".mysql_error()."</div>");
		
		$vI = 0;
		$vTabela = "";
		while($vLinha=mysql_fetch_row($vResult)){
			$vvNomeEmpresa = mysql_result($vResult,$vI,"NomeEmpresa");
			$vvIdCrypto = mysql_result($vResult,$vI,"vCodLink");
			$vvAbreviacaoEmpresa = mysql_result($vResult, $vI, "Abreviacao");
			$vvIdCliente = mysql_result($vResult, $vI, "IdCliente");							
			$vvNomeEmpresa = alterarCaracter($vvNomeEmpresa);
			$vvAbreviacaoEmpresa = alterarCaracter($vvAbreviacaoEmpresa);
			$vvIdCliente = alterarCaracter(substr($vvIdCliente,2, strlen($vvIdCliente)-2)."/".substr($vvIdCliente,0,2));
			$vvIdCrypto = criptografia($vvIdCrypto);
			
			$vvEndeBanco = mysql_result($vResult,$vI,"DB_Endereco");
			$vvUserBanco = mysql_result($vResult,$vI,"DB_Usuario");
			$vvPassBanco = mysql_result($vResult,$vI,"DB_Senha");
			$vvNomeBanco = mysql_result($vResult,$vI,"DB_Nome");
			$vvPortBanco = mysql_result($vResult,$vI,"DB_Porta");
			
			$vvIdsEletr  = "";
			$vvClass     = "";
			$vvProblFat  = "&nbsp;-&nbsp;";
			$vvProblParc = "&nbsp;-&nbsp;";
			$vvProblLeit = "&nbsp;-&nbsp;";
			$vvQteLig    = "&nbsp;-&nbsp;";
			$vvQteEcon   = "&nbsp;-&nbsp;";
			$vvVersaoSys = "&nbsp;-&nbsp;";
			
			$vPos = strpos($vvEndeBanco,'prosanearinfo');
			if($vPos === false){
				$vAtualizacao = "<a class='btn btn-link' href='http://autoatendimento.prosanearinfo.com.br/v5.0/index.php?id=".$vvIdCrypto."' title='Link com hospedagem de BD externo' rel='tooltip' target='_new'><span class='glyphicon glyphicon-globe' aria-hidden='true'></span></a>";	
			}else{
				$vvSQL = "SELECT *,(CASE WHEN DATE_FORMAT(now(),'%Y%m') = DATE_FORMAT(data_proc,'%Y%m') THEN '' ELSE 'danger' END) AS vClass FROM ".$vvNomeBanco.".controle";								
				$vControle = mysql_fetch_array(mysql_query($vvSQL,$conexao_gestcom));
				if (substr($vControle["data_proc"],11,8) != ""){
					$vAtualizacao = "&Uacute;ltima atualiza&ccedil;&atilde;o: ".@date('d/m/Y',strtotime(substr($vControle["data_proc"],0,10)))." &agrave;s ".substr($vControle["data_proc"],11,8);
				}else{
					$vAtualizacao = "&Uacute;ltima atualiza&ccedil;&atilde;o: ".@date('d/m/Y',strtotime(substr($vControle["data_proc"],0,10)));	
				}
				$vvClass = $vControle["vClass"];
				
				//criando tabela de acessosusuario
				$vvSQL = "CREATE TABLE IF NOT EXISTS ".$vvNomeBanco."._diagnosticosistema (
							  id             INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
							  DataRefSistema VARCHAR(6)       NOT NULL               ,
							  Verificacao    VARCHAR(50)      NOT NULL               ,
							  Diagnostico    TEXT             NOT NULL DEFAULT ''    ,
							  Comando        TEXT             NOT NULL DEFAULT ''    ,
							  Valor          VARCHAR(100)     NOT NULL               ,
							  PRIMARY KEY (id)
						)";
				mysql_query($vvSQL) or die('Erro ao criar Tabela _diagnosticoSistema: '.mysql_error());
								
				$vQte =0;
				$vvSQL = "SELECT COUNT(*) vConta FROM ".$vvNomeBanco."._diagnosticosistema";
				$busca0 = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar de diagnostico!<br/> - ".mysql_error()."</div>");
				if($vLinhaBusca0=mysql_fetch_row($busca0)){
					$vQte = mysql_result($busca0,0,"vConta");
					if($vQte > 0) {
					
						//buscar se existe problemas no faturamento
						$vvSQL = "SELECT COUNT(*) vConta FROM ".$vvNomeBanco."._diagnosticosistema WHERE Verificacao = 'FATURAMENTO' AND CAST(valor AS UNSIGNED) > 0";
						$busca1 = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar dados do faturamento!<br/> - ".mysql_error()."</div>");
						if($vLinhaBusca1=mysql_fetch_row($busca1)){
							$vQte = mysql_result($busca1,0,"vConta");
							$vvProblFat = "<a href='javascript:alerta_registro()' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-check' aria-hidden='true'></span>&nbsp;</a>";
							//if($vQte > 0) $vvProblFat = "<a href='javascript:exibirDadosFaturamento($vvNomeBanco)' class='btn btn-danger'>&nbsp;<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;</a>";
							if($vQte > 0) $vvProblFat = "<a href='diagnostico_resultado.php?cidade=$vvNomeBanco&emp=$vvNomeEmpresa&id=$vvIdCliente&ulti_atu=$vAtualizacao&verificacao=Faturamento' class='btn btn-danger'>&nbsp;<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;</a>";
						}
						
						//buscar se existe problemas no parcelamento
						$vvSQL = "SELECT COUNT(*) vConta FROM ".$vvNomeBanco."._diagnosticosistema WHERE Verificacao = 'PARCELAMENTO' AND CAST(valor AS UNSIGNED) > 0";
						$busca2 = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar dados do parcelamento!<br/> - ".mysql_error()."</div>");
						if($vLinhaBusca2=mysql_fetch_row($busca2)){
							$vQte = mysql_result($busca2,0,"vConta");
							$vvProblParc = "<a href='javascript:alerta_registro()' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-check' aria-hidden='true'></span>&nbsp;</a>";
							//if($vQte > 0) $vvProblParc = "<a href='javascript:exibirDadosParcelamento($vvNomeBanco)' class='btn btn-danger'>&nbsp;<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;</a>";
							if($vQte > 0) $vvProblParc = "<a href='diagnostico_resultado.php?cidade=$vvNomeBanco&emp=$vvNomeEmpresa&id=$vvIdCliente&ulti_atu=$vAtualizacao&verificacao=Parcelamento' class='btn btn-danger'>&nbsp;<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;</a>";
						}
						
						
						//buscar se existe problemas nas leituras
						$vvSQL = "SELECT COUNT(*) vConta FROM ".$vvNomeBanco."._diagnosticosistema WHERE Verificacao = 'LEITURA' AND CAST(valor AS UNSIGNED) > 0";
						$busca1 = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar dados da Leitura!<br/> - ".mysql_error()."</div>");
						if($vLinhaBusca1=mysql_fetch_row($busca1)){
							$vQte = mysql_result($busca1,0,"vConta");
							$vvProblLeit = "<a href='javascript:alerta_registro()' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-check' aria-hidden='true'></span>&nbsp;</a>";
							//if($vQte > 0) $vvProblFat = "<a href='javascript:exibirDadosFaturamento($vvNomeBanco)' class='btn btn-danger'>&nbsp;<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;</a>";
							if($vQte > 0) $vvProblLeit = "<a href='diagnostico_resultado.php?cidade=$vvNomeBanco&emp=$vvNomeEmpresa&id=$vvIdCliente&ulti_atu=$vAtualizacao&verificacao=Leitura' class='btn btn-danger'>&nbsp;<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;</a>";
						}
						
						
						//Qte de ligacoes
						$vvSQL = "SELECT SUM(CAST(valor AS UNSIGNED)) vConta FROM ".$vvNomeBanco."._diagnosticosistema WHERE Verificacao = 'USU�RIO' AND Comando IN ('A','D','P', 'C', 'T', 'F', 'Z')";
						$busca3 = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar qte de liga��es!<br/> - ".mysql_error()."</div>");
						if($vLinhaBusca3=mysql_fetch_row($busca3)){
							$vQte = mysql_result($busca3,0,"vConta");
							//$vvQteLig = "<a href='#' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-user' aria-hidden='true'></span>&nbsp;$vQte</a>";
							$vvQteLig = "<a href='diagnostico_resultado.php?cidade=$vvNomeBanco&emp=$vvNomeEmpresa&id=$vvIdCliente&ulti_atu=$vAtualizacao&verificacao=Usuario&diagnostico=1' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-user' aria-hidden='true'></span>&nbsp;$vQte</a>";
						}
						
						//Qte de economias
						$vvSQL = "SELECT SUM(CAST(valor as UNSIGNED)) vConta FROM ".$vvNomeBanco."._diagnosticosistema WHERE Verificacao = 'USU�RIO' and Comando IN ('DOM','COM','IND', 'PUB', 'OUT')";
						$busca4 = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar qte de liga��es!<br/> - ".mysql_error()."</div>");
						if($vLinhaBusca4=mysql_fetch_row($busca4)){
							$vQte = mysql_result($busca4,0,"vConta");
							//$vvQteEcon = "<a href='#' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-tint' aria-hidden='true'></span>&nbsp;$vQte</a>";
							$vvQteEcon = "<a href='diagnostico_resultado.php?cidade=$vvNomeBanco&emp=$vvNomeEmpresa&id=$vvIdCliente&ulti_atu=$vAtualizacao&verificacao=Usuario&diagnostico=2' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-tint' aria-hidden='true'></span>&nbsp;$vQte</a>";
						}				
						
						//versão do sistema
						$vvVersao = "";
						$vValor   = "";
						$vRelease = "";
						$vvSQL = "SELECT Valor FROM ".$vvNomeBanco."._diagnosticosistema WHERE Verificacao = 'VERSAO'";
						$busca5 = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar vers&atilde;o do sistema!<br/> - ".mysql_error()."</div>");
						if($vLinhaBusca5=mysql_fetch_row($busca5)){
							$vValor = mysql_result($busca5,0,"Valor");
							if(strlen(trim($vValor)) > 0) {
								$vValor  = mascara_string_c($vValor,'#.#.##');
								$vvVersao = $vValor;
							}
						}
						$vvSQL = "SELECT Valor FROM ".$vvNomeBanco."._diagnosticosistema WHERE Verificacao = 'RELEASE'";
						$busca6 = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar release do sistema!<br/> - ".mysql_error()."</div>");
						if($vLinhaBusca6=mysql_fetch_row($busca6)){
							$vValor = mysql_result($busca6,0,"Valor");
							if(strlen(trim($vValor)) > 0) $vRelease = "#".$vValor;
						}						
						if(strlen($vvVersao)>0)
							$vvVersaoSys = "<a href='javascript:alert(\"Vers&atilde;o do sistema: \\n".$vvVersao." \\n".$vRelease ."\")' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>&nbsp;$vvVersao<br>$vRelease</a>";
						
					}
				}
			}
			$vvIcon = "";
			if(strlen($vvClass) > 0) {
				$vvClass = " class='".$vvClass."'";
				$vvIcon = "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;";
			}
			
			$vTabela .= "<tr $vvClass>";
			$vTabela .= "<td>".$vvIcon.$vvNomeEmpresa."</td>";
			$vTabela .= "<td class='text-center'>$vvIdCliente</td>";
			$vTabela .= "<td class='text-center'>$vAtualizacao</td>";
			$vTabela .= "<td class='text-center'>$vvProblFat</td>";
			$vTabela .= "<td class='text-center'>$vvProblParc</td>";
			$vTabela .= "<td class='text-center'>$vvProblLeit</td>";
			$vTabela .= "<td class='text-center'>$vvVersaoSys</td>";
			$vTabela .= "<td class='text-center'>$vvQteLig</td>";
			$vTabela .= "<td class='text-center'>$vvQteEcon</td>";
			//$vTabela .= "<td class='text-center'> <a href='diagnostico_resultado.php?cidade=$vvNomeBanco'onClick='verifica_cidade(3, $vI)' class='text-center'>$vvQteEcon</td>"; 
			//$vTabela .= "<td class='text-center'> <a href='diagnostico_resultado.php?cidade=$vvNomeBanco&emp=$vvNomeEmpresa&id=$vvIdCliente' class='text-center'>$vvQteEcon</td>"; 
			$vTabela .= "</tr>";
			
			$vI++;
		}
		
	?>
	
		<script>
		function alerta_registro() {
			alert("Não há digervência!");
		}
		</script>
		
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
            <a class="navbar-brand" href="principal.php"><img src="../imagens/logo_gestcom.png" alt="" class="img-responsive" height="30px" width="127px" /></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rotina de suporte<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="diagnostico.php">Libera&ccedil;&atilde;o de telas</a></li>
                  <!--<li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>-->
                </ul>
              </li>
			  <?php
			  if($vvTipoUsuario == 0){
			  	echo ("<li class='active'><a href='diagnosticoClientes.php'>Diagn&oacute;stico de clientes</a></li>");
				echo ("<li ><a href='configuracoes.php'>Configura&ccedil;&otilde;es</a></li>");
			  }
			  ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo($vvNomeUsuario); ?><span class="caret"></span></a>
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
        <h1>Diagn&oacute;stico de clientes</h1>
        <p>&nbsp;</p>
		<p>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center col-md-3">Empresa</th>
							<th class="text-center col-md-2">Cidade/UF</th>
							<th class="text-center col-md-3">Dt Atualiza&ccedil;&atilde;o</th>
							<th class="text-center col-md-1">Diag Faturamento</th>
							<th class="text-center col-md-1">Diag Parcelamento</th>
							<th class="text-center col-md-1">Diag Leitura</th>
							<th class="text-center col-md-1">Vers&atilde;o Sistema</th>
							<th class="text-center col-md-1">Qte liga&ccedil;&otilde;es</th>
							<th class="text-center col-md-1">Qte economias</th>
						</tr>
					</thead>
					<tbody id='tbListaUsuario'>
					<?php
						echo($vTabela);
					?>
			
					</tbody>
				</table>
			</div>
		</p>  
      </div>
    </div> <!-- /container -->
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Novo usu&aacute;rio</h4>
		  </div>
		  <div class="modal-body">
		  	<form>
				<div class="form-group row">
	 		    	<label for="inputNome" class="col-sm-2 col-form-label">Nome:</label>
      				<div class="col-sm-10">
        				<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" />
      				</div>
    			</div>
				<div class="form-group row">
	 		    	<label for="inputMotivo" class="col-sm-2 col-form-label">E-mail:</label>
      				<div class="col-sm-10">
        				<input type="email" class="form-control" id="email" name="email" placeholder="E-mail" />
      				</div>
    			</div>
				<div class='form-group row'>
					 <label for='inputCliente' class='col-sm-2 col-form-label'>Cliente:</label>
					 <div class='col-sm-10'>
					 	<?php
							$vvClientes = buscaListaClientes();
							echo($vvClientes);
						?>
					 </div>
				</div>
				<div class="form-group row">
	 		    	<label for="inputLogin" class="col-sm-2 col-form-label">Login:</label>
      				<div class="col-sm-10">
        				<input type="text" class="form-control" id="login" name="login" placeholder="Login" maxlength="20" />
      				</div>
    			</div>
				<div class="form-group row">
	 		    	<label for="inputSenha" class="col-sm-2 col-form-label">Senha:</label>
      				<div class="col-sm-10">
        				<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" maxlength="10" />
      				</div>
					<label for="inputSenha" class="col-sm-2 col-form-label">Repita a senha:</label>
      				<div class="col-sm-10">
        				<input type="password" class="form-control" id="senha2" name="senha2" placeholder="Repita a senha" maxlength="10" />
      				</div>
    			</div>
			</form>
		  </div>
		  <div class="modal-footer">
		  	<a class="btn btn-primary btn-lg" role="button" href="javascript:gravarNovoUsuario();">Gravar</a>
			<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Fechar</button>			
		  </div>
		</div>
	  </div>
	</div>
	
	<script type="text/javascript">
		$('#myModal').on('shown.bs.modal', function () {
		  //$("#lblContraChave").html(chave);
		  $('#myInput').focus();		  
		});
		
		function gravarNovoUsuario(){
			var nome    = document.getElementById("nome").value;
			var email   = document.getElementById("email").value;
			var cliente = document.getElementById("cboCliente").value;
			var login   = document.getElementById("login").value;
			var senha1  = document.getElementById("senha").value;
			var senha2  = document.getElementById("senha2").value;
			
			var validou = true;
			
			//valida��o
			if(nome.length == 0){
				alert('Digite o nome do usuario.');
				validou = false;
			}
			
			if(email.length == 0 && validou){
				alert('Digite o email do usuario.');
				validou = false;				
			}
			
			if(cliente == 0 && validou){
				alert('Selecione um cliente.');
				validou = false;
			}
			
			if(login.length == 0 && validou){
				alert('Digite o login para acesso.');
				validou = false;
			}
			
			if(senha1.length == 0 && validou){
				alert('Digite a senha para acesso.');
				validou = false;
			}
			
			if(senha2.length == 0 && validou){
				alert('Digite a confirmacao da senha para acesso.');
				validou = false;
			}			

			if(senha1 != senha2 && validou){
				alert('A confirmacao da senha nao confere com a senha digitada');
				validou = false;
			}
			
			if(validou){
				var vData = novoUsuario(nome, email, cliente, login, senha1);
				var vMsg = vData.substring(0,3);
				vData = vData.substring(3, vData.lenght);
				if(vMsg == "ER.") {
					alert('Atencao!!!\nOcorreu um problema na execucao da funcao. Operacao sera cancelada!\nErr.: ' + vData);										
				}else{
					$("#tbListaUsuario").html(vData);
					$('#myModal').modal('hide');
				}
			}
		}//
		
		function excluirUsuario(usuarioID){
			var r = confirm('Deseja realmente excluir este registro?');
			if(r == true){
				var vData = exclusaoUsuario(usuarioID);
				var vMsg = vData.substring(0,3);
				vData = vData.substring(3, vData.lenght);
				if(vMsg == "ER.") {
					alert('Atencao!!!\nOcorreu um problema na execucao da funcao. Operacao sera cancelada!\nErr.: ' + vData);										
				}else{
					$("#tbListaUsuario").html(vData);
				}
			}
		}
		
		
		function novoUsuario(nome, email, cliente, login, senha){		
			var vTemp = "";
			var vTipo = 1;
			bodyContent = $.ajax({
				  url: "funcoes.php",
				  global: false,
				  type: "POST",
				  data: ({hTipo: vTipo, hNome : nome, hEmail : email, hCliente : cliente, hLogin : login, hSenha : senha}),
				  dataType: "html",
				  async:false,
				  success: function(msg){
					 return msg;
				  }
			   }
			).responseText;	//
			return bodyContent;		
		}
		
		function exclusaoUsuario(usuarioID){		
			var vTemp = "";
			var vTipo = 2;
			bodyContent = $.ajax({
				  url: "funcoes.php",
				  global: false,
				  type: "POST",
				  data: ({hTipo: vTipo, hUsuarioID : usuarioID}),
				  dataType: "html",
				  async:false,
				  success: function(msg){
					 return msg;
				  }
			   }
			).responseText;	//
			return bodyContent;		
		}				
	</script>	
<!--	Tiago 01/2018 -->
	<script>
		function verifica_cidade(x,y) 
		{
			
			
			//var getColumnValue = function(cidade, index) {
			//  var column = null;
			  
			 // $('table th').each(function(index, item) {
				//encontra o index da coluna em causa
				//column = $(item).text() == empresa ? index : column;
			  //});
			
			  //$('table tr').each(function(row, item) {
				//if (row != index + 1) return; //salta se a linha nao for a desejada
				//columnValue = $(item).find('td').eq(column); //pega a celula da tabela
				//columnValue = $(item).text() == empresa ? index : column;
			 // });
			
			  //return $(columnValue).text();
			 // return $(retorno).text();
			//};
			
			//index definido por numero
			//$valor = $('.table td').eq(0).text(); 
			//$valor = $('.table td').eq(1).text(); 
			//alert("resultado com index numérico = " + $valor);
			$valor2 = $('.table tr').eq(y+1).text(); 
			alert("resultado com index numérico = " + $valor2);
			//return $valor2;
			//alert('Você clicou na linha '+ y +', coluna '+ x +'.');
			//index definido pelo nome da coluna
			//$valor = getColumnValue("Firstname", 1); //alterado para chamar a função costumisada
			//alert("resultado com o nome da coluna = " + $valor);
			
		}
	</script>
	
	
</body>
</html>