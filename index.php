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

	<script type="text/javascript">
		function validateForm() {
		    var vLogin = document.getElementById("Login").value;
			var vSenha = document.getElementById("Password").value;
		    if(vLogin.length == 0){
			    alert("Usuario em branco. Verifique!");
			    return false;
		    }else{
				if(vSenha.length == 0){
					alert("Senha em branco. Verifique!");
				    return false;
				}else
					return true;				
			}
	    }
	</script>

</head>
<?php
	
	ob_start();
	session_start();
	$vvErro = $_SESSION["erro"];
	
	$vvMensagemErro = "";
	if(strlen($vvErro) > 0){
		$vvMensagemErro = "<div class='alert alert-danger' role='alert'>
		                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
							 	<span aria-hidden='true'>&times;</span>
							 </button>
							 <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
							 <span class='sr-only'>Error ao fazer o Login:</span>&nbsp;$vvErro<br/>
						   </div>";
		$_SESSION["erro"] = "";
	}
?>
<body style="padding: 50px 0;">
	
	<div class="container">
    	<div class="row">
        	<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            	<div class="well well-shadow">
                	<form action="redirect.php" method="post" onSubmit="return validateForm()" name="form" role="form" novalidate autocomplete="off" >					
                    	<p><img src="images/OSsMap2.png" alt="" class="img-responsive" /></p>
                    	<p class="text-center">Preencha os campos abaixo para acessar o sistema</p>
                    	<div class="form-group" >
                        	<label for="Login" class="sr-only">Usu&aacute;rio</label>
                        	<div class="input-group">
                            	<div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                            	<input type="text" id="Login" name="Login" class="form-control" placeholder="Usu&aacute;rio" required autofocus>
                        	</div>
                    	</div>
                    	<div class="form-group">
                        	<label for="Password" class="sr-only">Senha</label>
	                        <div class="input-group">
								<div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
								<input type="password" id="Password" name="Password" class="form-control" placeholder="Senha" required>
							</div>
						</div>
						<button class="btn btn-lg btn-primary btn-block" type="submit" >
							<span>Entrar <i class="glyphicon glyphicon-log-in"></i></span>
						</button>
						<?php
							if(strlen($vvMensagemErro) > 0) {
								echo($vvMensagemErro);
							}
						?>
	                </form>
    	        </div>
        	</div>
		</div>
	</div>	
</body>
</html>
