<?php
	ini_set('display_errors', true);
	
	$host  = "autoatendimento.prosanearinfo.com.br";
	$login = "autoatendimento";
	$senha = "gest@123mgf";
	$banco = "ossmap";
	
	$cConexao = mysql_connect($host,$login,$senha) or die ("Nao foi possivel realizar a conexao com o servidor!!!");   
   	$db_gestcom = mysql_select_db($banco,$cConexao) or die ("Nao foi possivel selecionar o banco de dados!!!");
	
?>