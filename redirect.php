<?php
	$conexaoSys = "";
	require_once('conexao.php');
	
	ob_start();
	$vvUsuario = $_POST["username"];
	$vvSenha = $_POST["password"];
	session_start();
	try {
		if(strlen($vvUsuario) > 0){
			//$conn = new PDO("mysql:host=$vvEndeBanco;dbname=$vvNomeBanco;port=$vvPortBanco", $vvUserBanco, $vvPassBanco);
			// set the PDO error mode to exception
			//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
			$vSQL = "SELECT u.*  FROM usuario u WHERE u.username = '".ltrim(rtrim($vvUsuario))."' AND u.enabled = 1";
			$stmt = $conn->query($vSQL);
			if($vUsuario  = $stmt->fetch()){
				$vvUsuarioID  = $vUsuario["id"];
				$vvSenhaBD    = $vUsuario["senha"];
				$vvNome       = $vUsuario["nome"];			
				$vTipoUsuario = $vUsuario["tipoUsuario"];
				if(strtoupper(ltrim(rtrim($vvSenha))) == strtoupper(ltrim(rtrim($vvSenhaBD)))){
					$_SESSION['idUsuario'] = $vvUsuarioID;
					$_SESSION['mensagem'] = "Bem-vindo $vvNome!";
					$_SESSION['role'] = $vRole;
					$_SESSION['nomeUsuario'] = $vvNome;
					$_SESSION['tipoUsuario'] = $vTipoUsuario;
					header("location:principal.php");
				}else{
					$_SESSION['erro'] = "Senha n&atilde;o confere.";
					header("location:index.php");
				}
			}else{
				$_SESSION['erro'] = "Usu&aacute;rio n&atilde;o cadastrado.";
				header("location:index.php");
			}
		}
	}catch(PDOException $e){
		$_SESSION['erro'] = "Erro ao consultar usuario: ".$e->getMessage();
		header("location:index.php");
	}
	
?>