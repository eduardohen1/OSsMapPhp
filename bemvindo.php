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
   <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
   <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
	<style type="text/css">
        .well-shadow {  -webkit-box-shadow: 0 10px 6px -6px #777; -moz-box-shadow: 0 10px 6px -6px #777; box-shadow: 0 10px 6px -6px #777; }
    </style>
</head>
<?php
   ob_start();
   session_start();
   $vvNomeUsuario = $_SESSION['nomeUsuario'];	
   $vvMensagem    = $_SESSION['mensagem'];
?>
<body style="padding: 50px 0; background-color: #607fbe;" onload="mensagemBemVindo();">
   <table width="100%" border="0">
      <tr>
         <td align="center"><img src="images/OSsMap2.png" alt="" class="img-responsive" height="100px" width="400px" /></td>
      </tr>
   </table>
   <script type="text/javascript">
      function mensagemBemVindo(){
         Swal({
            title: 'OSsMap - Sistema de Ordens de Servi&ccedil;os',
            text: '<?php echo($vvMensagem); ?>',
            imageUrl: 'url(/images/OSsMap.png)',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'OSsMap',
            animation: false
         });
         //window.location.replace("principal.php");
      }
   </script>
</body>
</html>