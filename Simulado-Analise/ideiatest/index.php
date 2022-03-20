<?php 
	
	session_start();
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Provas</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="script.js"></script>
	<meta charset="utf-8">
</head>
<body>
	<div id="logo">
		
	</div>
	<div id="menu">
		Ano: <select name="ano" id="txtAno">
   				<option value="2015">2015</option>
   				<option value="2016">2016</option>
   				<option value="2017">2017</option>
			</select>

		Caderno: <select name="cor" id="txtCor">
   					<option value="AMARELO">Amarelo</option>
   					<option value="AZUL">Azul</option>
   					<option value="BRANCO">Branco</option>
   					<option value="ROSA">Rosa</option>
				</select>

		<button id="btnEnvie">Gerar Excel</button>

	</div>

	<div id="conteudo">
		
	</div>
</body>
</html>