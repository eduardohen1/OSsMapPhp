<?php
	ini_set('display_errors', true);
	
	$host        = "autoatendimento.prosanearinfo.com.br";
	$login       = "autoatendimento";
	$senha       = "gest@123mgf";
	$banco       = "ossmap";
	$vvPortBanco = "3309";
	$conn        = "";

	try {
    	$conn = new PDO("mysql:host=$host;dbname=$banco;port=$vvPortBanco", $login, $senha);
	    // set the PDO error mode to exception
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexaoSysCliente = $conn;
    }catch(PDOException $e){
		echo('Erro: '.$e->getMessage());
		exit;
    }
?>