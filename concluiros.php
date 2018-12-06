<?php
   $vvNumOs = $_GET['numos'];
   $vvAnoOs = $_GET['anoos'];

   $host        = "autoatendimento.prosanearinfo.com.br";
   $login       = "autoatendimento";
   $senha       = "gest@123mgf";
   $banco       = "ossmap";
   $vvPortBanco = "3309";
   $conn        = "";

   try {    
      $conn = new PDO("mysql:host=$host;dbname=$banco;port=$vvPortBanco", $login, $senha);	    
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
      $vSQL = "UPDATE os SET situacao = 3 WHERE num_os = ".$vvNumOs." AND ano_os = ".$vvAnoOs;
      $conn->query($vSQL);
      header("location:principal.php");
   }catch(PDOException $e){
      echo('Erro: '.$e->getMessage());
      exit;
 }

?>