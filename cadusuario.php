<!DOCTYPE>
<html lang="pt-br">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Contet-Type" content="text/html; charset=UTF-8" /> <!-- Meta para responsibilidade -->
	<meta name="viewport" content="width=device-width" /><!-- Meta para responsibilidade -->
	<title>Rotinas de suporte - Sistema de Gest&atilde;o Comercial</title>

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
			  	echo ("<li ><a href='diagnosticoClientes.php'>Diagn&oacute;stico de clientes</a></li>");
				echo ("<li class='active'><a href='configuracoes.php'>Configura&ccedil;&otilde;es</a></li>");
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
        <h1>Cadastro de usu&aacute;rios</h1>
        <p>&nbsp;</p>
		<p><button type="button" id="btnGerar" name="btnGerar" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Novo usu&aacute;rio</button></p>
		<p>
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center col-md-3">Usu&aacute;rio</th>
							<th class="text-center col-md-2">Tipo</th>
							<th class="text-center col-md-2">Cidade/UF</th>
							<th class="text-center col-md-3">Empresa</th>
							<th class="text-center col-md-2">Dt Ult acesso</th>
							<th class="text-center col-md-1">...</th>
						</tr>
					</thead>
					<tbody id='tbListaUsuario'>
					<?php
						$vvListaUsuarios = buscaListaUsuarios();
						echo($vvListaUsuarios);
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
				<div class="form-group row">
	 		    	<label for="inputTipo" class="col-sm-2 col-form-label">Tipo usu&aacute;rio:</label>
      				<div class="col-sm-10">
						<select class='form-control' id='cboTipoUsuario' name='cboTipoUsuario'>
							<option value='0'>Gestor TI</option>
							<option value='1'>Acesso WebService</option>
						</select>
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
			var nome         = document.getElementById("nome").value;
			var email        = document.getElementById("email").value;
			var cliente      = document.getElementById("cboCliente").value;
			var login        = document.getElementById("login").value;
			var senha1       = document.getElementById("senha").value;
			var senha2       = document.getElementById("senha2").value;
			var vTipoUsuario = document.getElementById("cboTipoUsuario").value;
			
			var validou = true;
			
			//validação
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
				var vData = novoUsuario(nome, email, cliente, login, senha1, vTipoUsuario);
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
		
		
		function novoUsuario(nome, email, cliente, login, senha, vTipoUsuario){		
			var vTemp = "";
			var vTipo = 1;
			bodyContent = $.ajax({
				  url: "funcoes.php",
				  global: false,
				  type: "POST",
				  data: ({hTipo: vTipo, hNome : nome, hEmail : email, hCliente : cliente, hLogin : login, hSenha : senha, hTipoUsuario : vTipoUsuario}),
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
		
		/*
		$(document).ready(function() {
			$("#chave").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					 // Allow: Ctrl/cmd+A
					(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
					 // Allow: Ctrl/cmd+C
					(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
					 // Allow: Ctrl/cmd+X
					(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});
		});
		
		function gerarChave() {
			var resposta = "";
			var vvIdUsuario   = document.getElementById("idUsuario").value;
			var vvClienteID   = document.getElementById("ClienteID").value;
			var vvChave       = document.getElementById("chave").value;
			var vvMotivo      = document.getElementById("motivo").value;
			var vvTipoUsuario = document.getElementById("tipoUsuario").value;
			
			var vRetorno = true;
			if(vvTipoUsuario == 0){
				vvClienteID = document.getElementById("cboCliente").value;
				if(vvClienteID.length == 0){
					alert("Selecione um cliente para gerar a contra-chave.");
					vRetorno = false;
				}
			}
			
		    if(vvChave.length == 0){
			    alert("Chave em branco. Verifique!");
		    }else{
				if(vvMotivo.length == 0){
					alert("Motivo em branco. Verifique!");
				}else{
					if(vRetorno){
						var vData = buscaValores(vvIdUsuario, vvClienteID, vvChave, vvMotivo);
						var vMsg = vData.substring(0,3);
						vData = vData.substring(3, vData.lenght);
						if(vMsg == "ER.") {
							alert('Atencao!!!\nOcorreu um problema na execucao da funcao. Operacao sera cancelada!\nErr.: ' + vData);										
						}else{
							resposta = vData;
						}
					}
				}
			}
			return resposta;
		}
		
		function buscaValores(vvIdUsuario, vvClienteID, vvChave, vvMotivo){		
			var vTemp = "";
			bodyContent = $.ajax({
				  url: "funcoes.php",
				  global: false,
				  type: "POST",
				  data: ({hIdUsuario : vvIdUsuario, hClienteID : vvClienteID, hChave : vvChave, hMotivo : vvMotivo}),
				  dataType: "html",
				  async:false,
				  success: function(msg){
					 return msg;
				  }
			   }
			).responseText;	//
			return bodyContent;		
		}
		*/	
	</script>	
	
	
</body>
</html>