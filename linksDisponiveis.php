<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Contet-Type" content="text/html; charset=UTF-8" /> <!-- Meta para responsibilidade -->
	<meta name="viewport" content="width=device-width" /><!-- Meta para responsibilidade -->
	<title>Listagem de links dispon&iacute;veis - GestCom Inform&aacute;tica</title>

	<link rel="shortcut icon" href="http://www.prosanearinfo.com.br/gota.ico" />
	<link rel="stylesheet" type="text/css" href="scripts/static/css/bootstrap.min.css">
	<script type="text/javascript" src="scripts/static/js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="scripts/static/js/bootstrap.min.js"></script>		
</head>
<?php
include('v5.0/scripts/funcoes.php');	

/**
* EXEMPLO DE USO mascara_string_c
*<?
*$cnpj = "11222333000199";
*$cpf = "00100200300";
*$cep = "08665110";
*$data = "10102010";
*echo mask($cnpj,'##.###.###/####-##');
*echo mask($cpf,'###.###.###-##');
*echo mask($cep,'#####-###');
*echo mask($data,'##/##/####');
*?>
*/
$conexaoSysCliente = "";

function mascara_string_c($val, $mask){
	$maskared = '';
	$k = 0;
	for($i = 0; $i <= strlen($mask)-1; $i++){
		if($mask[$i] == '#'){
			if(isset($val[$k]))
				$maskared .= $val[$k++];
		}else{
			if(isset($mask[$i]))
				$maskared .= $mask[$i];
		}
	}
	return $maskared;
}
function conexaoClienteOnline($vvEndeBanco, $vvPortBanco, $vvUserBanco, $vvPassBanco, $vvNomeBanco){
	$resposta = true;
	try {
    	$conn = new PDO("mysql:host=$vvEndeBanco;dbname=$vvNomeBanco;port=$vvPortBanco", $vvUserBanco, $vvPassBanco);
	    // set the PDO error mode to exception
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexaoSysCliente = $conn;
    }catch(PDOException $e){
	    $resposta = false;
    }
	return $resposta;
}
function retornaConexaoCliente($vvEndeBanco, $vvPortBanco, $vvUserBanco, $vvPassBanco, $vvNomeBanco){
	$resposta = NULL;
	try {
    	$conn = new PDO("mysql:host=$vvEndeBanco;dbname=$vvNomeBanco;port=$vvPortBanco", $vvUserBanco, $vvPassBanco);
	    // set the PDO error mode to exception
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$resposta = $conn;
    }catch(PDOException $e){
	    $resposta = NULL;
    }
	return $resposta;
}
function buscaUltAtualizacaoCliente($conn) {
	$resposta = "";
	try {
    	//$conn = new PDO("mysql:host=$vvEndeBanco;dbname=$vvNomeBanco;port=$vvPortBanco", $vvUserBanco, $vvPassBanco);
	    // set the PDO error mode to exception
    	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
		$stmt = $conn->query("SELECT *,(CASE WHEN DATE_FORMAT(now(),'%Y%m') = DATE_FORMAT(data_proc,'%Y%m') THEN '' ELSE 'danger' END) AS vClass FROM controle");
		if($vControle  = $stmt->fetch()){
			if (substr($vControle["data_proc"],11,8) != ""){
				$resposta = "&Uacute;ltima atualiza&ccedil;&atilde;o: ".@date('d/m/Y',strtotime(substr($vControle["data_proc"],0,10)))." &agrave;s ".substr($vControle["data_proc"],11,8);
			}else{
				$resposta = "&Uacute;ltima atualiza&ccedil;&atilde;o: ".@date('d/m/Y',strtotime(substr($vControle["data_proc"],0,10)));	
			}
		}else{
			$resposta = "<a class='btn btn-link' href='http://autoatendimento.prosanearinfo.com.br/v5.0/index.php?id=".$vvIdCrypto."' title='Link com hospedagem de BD externo' rel='tooltip' target='_new'><span class='glyphicon glyphicon-globe' aria-hidden='true'></span></a>";
		}
    }catch(PDOException $e){
	    $resposta = "&nbsp;-&nbsp;";
    }
	return $resposta;
}
function buscaIdsCliente($conn){
	$resposta = "";
	try {
    	//$conn = new PDO("mysql:host=$vvEndeBanco;dbname=$vvNomeBanco;port=$vvPortBanco", $vvUserBanco, $vvPassBanco);
	    // set the PDO error mode to exception
    	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
		$stmt = $conn->query("SELECT CONCAT(LPAD(CAST(cod_ligacao AS CHAR(5)),5,'0'),'-',dv_ligacao) vCodLigacao, CONCAT(dv_ligacao, LPAD(CAST(sub_quadrante_rota as CHAR(2)),2,'0'),cod_ligacao,'@',quadrante_zona) vIdEletronico FROM usuario LIMIT 5");
		while($vControle  = $stmt->fetch()){		
			$vvCodLig = $vControle["vCodLigacao"];
			$vvIdElet = $vControle["vIdEletronico"];
			if(strlen($resposta) > 0) $resposta .= "<br/>";
			$resposta .= "<small>".$vvCodLig."&nbsp;[".$vvIdElet."]</small>";		
		}
		if(strlen($resposta) == 0) $resposta = "&nbsp;-&nbsp;";
    }catch(PDOException $e){
	    $resposta = "&nbsp;-&nbsp;";
    }
	return $resposta;
}
function buscaVersaoCliente($conn){
	$resposta = "";
	try {
    	//$conn = new PDO("mysql:host=$vvEndeBanco;dbname=$vvNomeBanco;port=$vvPortBanco", $vvUserBanco, $vvPassBanco);
	    // set the PDO error mode to exception
    	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
		$vvVersao = "";
		$vValor   = "";
		$vRelease = "";
		$stmt = $conn->query("SELECT Valor FROM _diagnosticosistema WHERE Verificacao = 'VERSAO'");
		if($vControle  = $stmt->fetch()){
			$vValor = $vControle["Valor"];
			if(strlen(trim($vValor)) > 0) {
				$vValor  = mascara_string_c($vValor,'#.#.##');
				$vvVersao = $vValor;
			}
		}		
		$stmt2 = $conn->query("SELECT Valor FROM _diagnosticosistema WHERE Verificacao = 'RELEASE'");
		if($vControle2  = $stmt2->fetch()){
			$vValor = $vControle2["Valor"];
			if(strlen(trim($vValor)) > 0) $vRelease = "#".$vValor;			
		}						
		if(strlen($vvVersao)>0){
			$resposta = "<a href='javascript:alert(\"Vers&atilde;o do sistema: \\n".$vvVersao." \\n".$vRelease ."\")' class='btn btn-success'>&nbsp;<span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>&nbsp;$vvVersao<br>$vRelease</a>";
		}else{
			$resposta = "&nbsp;-&nbsp;";
		}
		
    }catch(PDOException $e){
	    $resposta = "&nbsp;-&nbsp;";
    }
	return $resposta;
}

//Conectar ao sistema gestcom
   	$conexao_gestcom = mysql_connect("192.168.1.250:3309","gestcomAdm","gestcom@123mgfpro") or die ("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;N&atilde;o foi poss&iacute;vel realizar a conex&atilde;o com o servidor GestCom(a)!<br/> - ".mysql_error()."</div>");   

	
   //seleciona a banco de dados contas
   	$db_gestcom = mysql_select_db("mgfinformatica",$conexao_gestcom) or die ("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;N&atilde;o foi poss&iacute;vel realizar a conex&atilde;o com o servidor GestCom(b)!<br/> - ".mysql_error()."</div>");

   //busca dados de conexao
   	$vSQL = "SELECT cl.*,CAST(CONCAT(LEFT(cc.CNPJ,2), cc.CodCliente, RIGHT(cc.CNPJ,2)) AS CHAR(20)) AS vCodLink, cc.NomeEmpresa, cc.Abreviacao, cc.IdCliente  FROM ClienteCadastro_Link AS cl INNER JOIN ClienteCadastro AS cc ON cl.CodCliente = cc.CodCliente ORDER BY cc.IdCliente";	
	
	$vResult = mysql_query($vSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar clientes!<br/> - ".mysql_error()."</div>");
/**/
?>
<body>
	<br />
	<div class="panel panel-primary eh-link-panel">
		<div class="panel-heading">
			<div class="clearfix">
				<h1 class="panel-title eh-titulo-panel">Listagem de links dispon&iacute;veis:</h1>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th class="text-center col-md-3">Nome empresa</th>
							<th class="text-center col-md-1">Abrevia&ccedil;&atilde;o</th>
							<th class="text-center col-md-2">Cidade/UF</th>
							<th class="text-center col-md-1">Vers&atilde;o do sistema</th>
							<th class="text-center col-md-2">Dt Ult Atualiza&ccedil;&atilde;o</th>
							<th class="text-center col-md-3">IDs teste</th>
							<th class="text-center col-md-3">Link</th>
						</tr>
					</thead>
					<tbody>
						<?php
						
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
							//$vvIdCliente = substr($vvIdCliente,2, $vvIdCliente.length()).'/'.substr($vvIdCliente,0,2);*/
							$vvIdCrypto = criptografia($vvIdCrypto);
							
							$vvEndeBanco = mysql_result($vResult,$vI,"DB_Endereco");
							$vvUserBanco = mysql_result($vResult,$vI,"DB_Usuario");
							$vvPassBanco = mysql_result($vResult,$vI,"DB_Senha");
							$vvNomeBanco = mysql_result($vResult,$vI,"DB_Nome");
							$vvPortBanco = mysql_result($vResult,$vI,"DB_Porta");
							
							$vvImgSys    = "/v5.0/imagens/256_logoGestCom.png";
							$vvIdsEletr  = "";
							$vvClass     = "";
							$vvVersaoSys = "&nbsp;-&nbsp;";
							$vvToolTip   = "Hospedagem no servidor GestCom";
							$vPos = strpos($vvEndeBanco,'prosanearinfo');
							if($vPos === false){
								$vvSistemaOnline = conexaoClienteOnline($vvEndeBanco,$vvPortBanco,$vvUserBanco,$vvPassBanco, $vvNomeBanco);
								if($vvSistemaOnline){
									$conn = retornaConexaoCliente($vvEndeBanco,$vvPortBanco,$vvUserBanco,$vvPassBanco, $vvNomeBanco);
									$vAtualizacao = buscaUltAtualizacaoCliente($conn);
									$vvIdsEletr   = buscaIdsCliente($conn);
									$vvVersaoSys  = buscaVersaoCliente($conn);
									$vvImgSys    = "/v5.0/imagens/256_sysClienteOn.png";
									$vvToolTip   = "Hospedagem do sistema On-line";
									$vvClass     = "";
								}else{
									$vAtualizacao = "<a class='btn btn-link' href='http://autoatendimento.prosanearinfo.com.br/v5.0/index.php?id=".$vvIdCrypto."' title='Link com hospedagem de BD externo' rel='tooltip' target='_new'><span class='glyphicon glyphicon-globe' aria-hidden='true'></span></a>";
									$vvIdsEletr  = "&nbsp;-&nbsp;";
									$vvVersaoSys = "&nbsp;-&nbsp;";
									$vvImgSys    = "/v5.0/imagens/256_sysClienteOff.png";			
									$vvToolTip   = "Hospedagem do sistema Off-line";
									$vvClass     = "warning";
								}								
							}else{
								$vvSQL = "SELECT *,(CASE WHEN DATE_FORMAT(now(),'%Y%m') = DATE_FORMAT(data_proc,'%Y%m') THEN '' ELSE 'danger' END) AS vClass FROM ".$vvNomeBanco.".controle";								
								$vControle = mysql_fetch_array(mysql_query($vvSQL,$conexao_gestcom));
								if (substr($vControle["data_proc"],11,8) != ""){
									$vAtualizacao = "&Uacute;ltima atualiza&ccedil;&atilde;o: ".@date('d/m/Y',strtotime(substr($vControle["data_proc"],0,10)))." &agrave;s ".substr($vControle["data_proc"],11,8);
								}else{
									$vAtualizacao = "&Uacute;ltima atualiza&ccedil;&atilde;o: ".@date('d/m/Y',strtotime(substr($vControle["data_proc"],0,10)));	
								}/**/
								$vvClass = $vControle["vClass"];
								//buscar alguns IDs para teste:
								
								$vvSQL = "SELECT CONCAT(LPAD(CAST(cod_ligacao AS CHAR(5)),5,'0'),'-',dv_ligacao) vCodLigacao, CONCAT(dv_ligacao, LPAD(CAST(sub_quadrante_rota as CHAR(2)),2,'0'),cod_ligacao,'@',quadrante_zona) vIdEletronico FROM ".$vvNomeBanco.".usuario LIMIT 5";
								$vvLigacao  = mysql_query($vvSQL)or die("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span><span class='sr-only'>Error:</span>&nbsp;Erro ao pesquisar ID-Eletr&ocirc;nico!<br/> - ".mysql_error()."</div>");
								$vY = 0;
								while($vLinha2=mysql_fetch_row($vvLigacao)){
									$vvCodLig = mysql_result($vvLigacao,$vY,"vCodLigacao");
									$vvIdElet = mysql_result($vvLigacao,$vY,"vIdEletronico");
									if(strlen($vvIdsEletr) > 0) $vvIdsEletr .= "<br/>";
									$vvIdsEletr .= "<small>".$vvCodLig."&nbsp;[".$vvIdElet."]</small>";
									$vY++;
								}
								if(strlen($vvIdsEletr)==0) $vvIdsEletr = "&nbsp;-&nbsp;";
								
								
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
							$vvIcon = "";
							if(strlen($vvClass) > 0) {								
								switch($vvClass){
									case "danger":									
										$vvIcon = "<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;";
										break;
									case "warning":
										$vvIcon = "<span class='glyphicon glyphicon-circle-arrow-down' aria-hidden='true'></span>&nbsp;";
										break;
								}
								$vvClass = " class='".$vvClass."'";
							}
							
							$vTabela .= "<tr $vvClass>";
							$vTabela .= "<td><table width='100%' border='0'><tr><td width='15%' align='center' valign='middle'><img src='$vvImgSys' width='32px' height='32px' alt='$vvToolTip' title='$vvToolTip' /></td><td width='85%'  align='left' valign='middle'>".$vvIcon.$vvNomeEmpresa."</td></tr></table></td>";
							$vTabela .= "<td class='text-center'>$vvAbreviacaoEmpresa</td>";
							$vTabela .= "<td>$vvIdCliente</td>";
							$vTabela .= "<td class='text-center'>$vvVersaoSys</td>";
							$vTabela .= "<td class='text-center'>$vAtualizacao</td>";
							$vTabela .= "<td>$vvIdsEletr</td>";
							$vTabela .= "<td>http://autoatendimento.prosanearinfo.com.br/v5.0/index.php?id=".$vvIdCrypto."&nbsp;";
							$vTabela .= "<a class='btn btn-link btn-xs' href='http://autoatendimento.prosanearinfo.com.br/v5.0/index.php?id=".$vvIdCrypto."' title='Link de ".$vvAbreviacaoEmpresa."' rel='tooltip' target='_new'>";
							$vTabela .= "<span class='glyphicon glyphicon-link'></span></a></td>";
							$vTabela .= "</tr>";
							//criptografia
							$vI++;
						}//while
						echo($vTabela);
						/**/
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>