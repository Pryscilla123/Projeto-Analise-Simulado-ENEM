<?php 
	
	session_start();
?>

<?php 
	
	$con = mysqli_connect("localhost", "root", "", "simulado")or die("Não conectou");

	mysqli_query($con, "SET NAMES utf8");

	if(isset($_GET["ano"]) || isset($_GET["cor"])){

		$_SESSION["ano"] = $_GET["ano"];
		$_SESSION["cor"] = $_GET["cor"];

		$ano = $_SESSION["ano"];
		$cor = $_SESSION["cor"];

		//echo $cor;
		//echo $ano;

		$cont = 0;
		$cont2 = 0;
		$dia = 0;
		$i = 0;
		$QntAP = 0;

		/*$sql = "SELECT * from simcadernos
				join simcadquestoes on simcadquestoes.simcaderno_id = simcadernos.id
				join simquestoes on simquestoes.id = simcadquestoes.simquestao_id
				where simcadernos.cor = '$cor' and simcadernos.modified like '%$ano%'";

		$sel = mysqli_query($con, $sql);

		while($linha = mysqli_fetch_assoc($sel)){
			$cont += 1;
			echo $cont . "-" . $linha["texto"] . "<br>"; 

			$id = $linha["id"];

			$sqlResp = "SELECT simrespostas.texto from simrespostas
						join simquestoes on simquestoes.id = simrespostas.simquestao_id
						WHERE simquestoes.id = '$id'";

			$selResp = mysqli_query($con, $sqlResp);

			while ($linhaResp = mysqli_fetch_assoc($selResp)) {

				echo "<ul>";
				echo "<li>" . $linhaResp["texto"] . "</li><br>";
				echo "</ul>";
			}

			if($cont < 96){
				$dia = 1;
			}else{
				$dia = 2;
			}

			for($i = 1; $i < 4; $i++){
					$sqlQntAP = "SELECT simalunos.ano, count(simalunos.id) as 'QntAP' from simalunos
							where simalunos.correcao$dia is not null and simalunos.ano = '$i' 
							and simalunos.created like '%$ano%'";

					$selQntAP = mysqli_query($con, $sqlQntAP);

					while($linhaQntAP = mysqli_fetch_assoc($selQntAP)){
						$QntAP = $linhaQntAP["QntAP"];
						echo $linhaQntAP["QntAP"] . "<br>";
					}
			}
		}*/
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Planilha</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<?php 
	
		$arquivo = $cor . $ano . ".xls";

		$html = '';

		$html .= '<table border = "1">';
		$html .= '<tr>';
		$html .= '<td colspan = "5">Planilha da Porcentagem de Acertos Por Ano do Caderno '. $cor . ' do Ano de ' . $ano . '</tr>';
		$html .= '</tr>';

		$html .= '<tr = "CN">';
		$html .= '<th id = "CN"><b>Questão</b></th>';
		$html .= '<th><b>% dos 1° anos</b></th>';
		$html .= '<th><b>% dos 2° anos</b></th>';
		$html .= '<th><b>% dos 3° anos</b></th>';
		//$html .= '<td><b>Porcentagem de Acertos</b></td>';
		$html .= '</tr>';

		$i = 0;
		$porcentagemP = [];
		$porcentagemS = [];
		$porcentagemT = [];

		$porcentagemPE = [];
		$porcentagemSE = [];
		$porcentagemTE = [];

		$porcentagemPI = [];
		$porcentagemSI = [];
		$porcentagemTI = [];

		$count = 0;

		$primeiroCE = [];
		$primeiroIE = [];
		$segundoCE = [];
		$segundoIE = [];
		$terceiroCE = [];
		$terceiroIE = [];

		$primeiroCI = [];
		$primeiroII = [];
		$segundoCI = [];
		$segundoII = [];
		$terceiroCI = [];
		$terceiroII = [];

		$primeiroC = [];
		$primeiroI = [];
		$segundoC = [];
		$segundoI = [];
		$terceiroC = [];
		$terceiroI = [];

		$totalP = [];
		$totalS = [];
		$totalT = [];

		$totalPE = [];
		$totalSE = [];
		$totalTE = [];

		$totalPI = [];
		$totalSI = [];
		$totalTI = [];

		$total = [];


		$sql = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
			sum(CASE
    			when simprovas.correta = 0 then 1 else 0
    		END) as 'Incorretas', simalunos.ano
			FROM `simprovas`
			join simcadernos on simcadernos.id = simprovas.simcaderno_id
			join simalunos on simalunos.id = simprovas.simaluno_id
			where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 1
			group by simprovas.questao";

			$sel = mysqli_query($con, $sql);

			while($linha = mysqli_fetch_assoc($sel)){
				$count++;

				$primeiroC[$count] = $linha["Corretas"];
				$primeiroI[$count] = $linha["Incorretas"];
				$totalP[$count] = $primeiroC[$count] + $primeiroI[$count];
			}

			$count = 0;

		$sqlS = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
				sum(CASE
    				when simprovas.correta = 0 then 1 else 0
    			END) as 'Incorretas', simalunos.ano
				FROM `simprovas`
				join simcadernos on simcadernos.id = simprovas.simcaderno_id
				join simalunos on simalunos.id = simprovas.simaluno_id
				where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 2
				group by simprovas.questao";

		$selS = mysqli_query($con, $sqlS);


		while($linhaS = mysqli_fetch_assoc($selS)){
			$count++;
			$segundoC[$count] = $linhaS["Corretas"];
			$segundoI[$count] = $linhaS["Incorretas"];
			$totalS[$count] = $segundoC[$count] + $segundoI[$count];
		}


		$sqlT = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
				sum(CASE
    				when simprovas.correta = 0 then 1 else 0
    			END) as 'Incorretas', simalunos.ano
				FROM `simprovas`
				join simcadernos on simcadernos.id = simprovas.simcaderno_id
				join simalunos on simalunos.id = simprovas.simaluno_id
				where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 3
				group by simprovas.questao";

		$selT = mysqli_query($con, $sqlT);

		$count = 0;

		while($linhaT = mysqli_fetch_assoc($selT)){
			$count++;
			$terceiroC[$count] = $linhaT["Corretas"];
			$terceiroI[$count] = $linhaT["Incorretas"];
			$totalT[$count] = $terceiroC[$count] + $terceiroI[$count];
		}

		$count = 0;

		$sqlE = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
			sum(CASE
    			when simprovas.correta = 0 then 1 else 0
    		END) as 'Incorretas', simalunos.ano
			FROM `simprovas`
			join simcadernos on simcadernos.id = simprovas.simcaderno_id
			join simalunos on simalunos.id = simprovas.simaluno_id
			where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 1 and simalunos.idioma = 'E'
			group by simprovas.questao";

			$selE = mysqli_query($con, $sqlE);

			while($linhaE = mysqli_fetch_assoc($selE)){
				$count++;

				if($count >= 91 && $count <= 95){

					//$count++;

					$primeiroCE[$count] = $linhaE["Corretas"];
					$primeiroIE[$count] = $linhaE["Incorretas"];
					$totalPE[$count] = $primeiroCE[$count] + $primeiroIE[$count];
				}
			}

			$count = 0;

		$sqlSE = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
				sum(CASE
    				when simprovas.correta = 0 then 1 else 0
    			END) as 'Incorretas', simalunos.ano
				FROM `simprovas`
				join simcadernos on simcadernos.id = simprovas.simcaderno_id
				join simalunos on simalunos.id = simprovas.simaluno_id
				where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 2 and simalunos.idioma = 'E'
				group by simprovas.questao";

		$selSE = mysqli_query($con, $sqlSE);


		while($linhaSE = mysqli_fetch_assoc($selSE)){
			$count++;
			if($count >= 91 && $count <= 95){

				//$count++;

				$segundoCE[$count] = $linhaSE["Corretas"];
				$segundoIE[$count] = $linhaSE["Incorretas"];
				$totalSE[$count] = $segundoCE[$count] + $segundoIE[$count];
			}
		}


		$sqlTE = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
				sum(CASE
    				when simprovas.correta = 0 then 1 else 0
    			END) as 'Incorretas', simalunos.ano
				FROM `simprovas`
				join simcadernos on simcadernos.id = simprovas.simcaderno_id
				join simalunos on simalunos.id = simprovas.simaluno_id
				where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 3 and simalunos.idioma = 'E'
				group by simprovas.questao";

		$selTE = mysqli_query($con, $sqlTE);

		$count = 0;

		while($linhaTE = mysqli_fetch_assoc($selTE)){
			$count++;
			if($count >= 91 && $count <= 95){

				//$count++;

				$terceiroCE[$count] = $linhaTE["Corretas"];
				$terceiroIE[$count] = $linhaTE["Incorretas"];
				$totalTE[$count] = $terceiroCE[$count] + $terceiroIE[$count];
			}
		}

		$count = 0;

		$sqlI = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
			sum(CASE
    			when simprovas.correta = 0 then 1 else 0
    		END) as 'Incorretas', simalunos.ano
			FROM `simprovas`
			join simcadernos on simcadernos.id = simprovas.simcaderno_id
			join simalunos on simalunos.id = simprovas.simaluno_id
			where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 1 and simalunos.idioma = 'I'
			group by simprovas.questao";

			$selI = mysqli_query($con, $sqlI);

			while($linhaI = mysqli_fetch_assoc($selI)){
				$count++;

				if($count >= 91 && $count <= 95){

					//$count++;

					$primeiroCI[$count] = $linhaI["Corretas"];
					$primeiroII[$count] = $linhaI["Incorretas"];
					$totalPI[$count] = $primeiroCI[$count] + $primeiroII[$count];
				}
			}

			$count = 0;

		$sqlSI = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
				sum(CASE
    				when simprovas.correta = 0 then 1 else 0
    			END) as 'Incorretas', simalunos.ano
				FROM `simprovas`
				join simcadernos on simcadernos.id = simprovas.simcaderno_id
				join simalunos on simalunos.id = simprovas.simaluno_id
				where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 2 and simalunos.idioma = 'I'
				group by simprovas.questao";

		$selSI = mysqli_query($con, $sqlSI);


		while($linhaSI = mysqli_fetch_assoc($selSI)){
			$count++;
			if($count >= 91 && $count <= 95){

				//$count++;

				$segundoCI[$count] = $linhaSI["Corretas"];
				$segundoII[$count] = $linhaSI["Incorretas"];
				$totalSI[$count] = $segundoCI[$count] + $segundoII[$count];
			}
		}


		$sqlTI = "SELECT substring(simcadernos.created, 1, 4) as 'Ano', simcadernos.cor as 'Cor', simcadernos.dia as 'Dia', simprovas.simcaderno_id as 'ID Caderno', simprovas.questao as 'Questão', sum(simprovas.correta) as 'Corretas',
				sum(CASE
    				when simprovas.correta = 0 then 1 else 0
    			END) as 'Incorretas', simalunos.ano
				FROM `simprovas`
				join simcadernos on simcadernos.id = simprovas.simcaderno_id
				join simalunos on simalunos.id = simprovas.simaluno_id
				where simcadernos.cor = '$cor' and simcadernos.created like '%$ano%' and simalunos.ano = 3 and simalunos.idioma = 'I'
				group by simprovas.questao";

		$selTI = mysqli_query($con, $sqlTI);

		$count = 0;

		while($linhaTI = mysqli_fetch_assoc($selTI)){
			$count++;
			if($count >= 91 && $count <= 95){

				//$count++;

				$terceiroCI[$count] = $linhaTI["Corretas"];
				$terceiroII[$count] = $linhaTI["Incorretas"];
				$totalTI[$count] = $terceiroCI[$count] + $terceiroII[$count];
			}
		}

		$count = 0;


		for($i=1; $i <= 180; $i++){

			//$total[$i] = $totalP[$i] + $totalS[$i] + $totalT[$i]; 

			if($i >= 1 && $i <= 45){
				$uc = 'CH';
			}else if($i >= 46 && $i <= 95){
				$uc = 'L';
			}else if($i >= 96 && $i <= 140){
				$uc = 'M';
			}else if($i >= 141 && $i <= 180){
				$uc = 'CN';
			}


			if($i >= 91 && $i <= 95){

				$porcentagemPI[$i] = intval(($primeiroCI[$i] * 100) / $totalPI[$i]);
				$porcentagemPE[$i] = intval(($primeiroCE[$i] * 100) / $totalPE[$i]);

				$porcentagemSI[$i] = intval(($segundoCI[$i] * 100) / $totalSI[$i]);
				$porcentagemSE[$i] = intval(($segundoCE[$i] * 100) / $totalSE[$i]);

				$porcentagemTI[$i] = intval(($terceiroCI[$i] * 100) / $totalTI[$i]);
				$porcentagemTE[$i] = intval(($terceiroCE[$i] * 100) / $totalTE[$i]);

				$html .= '<tr>';
				$html .= '<td id="'.$uc.'">'.$i.'</td>';

				$html .= '<td id="'.$uc.'">I'. $porcentagemPI[$i]. '%/E'. $porcentagemPE[$i] .'%</td>';
				$html .= '<td id="'.$uc.'">I'. $porcentagemSI[$i]. '%/E'. $porcentagemSE[$i] .'%</td>';
				$html .= '<td id="'.$uc.'">I'. $porcentagemTI[$i]. '%/E'. $porcentagemTE[$i] .'%</td>';
			}else{

				$html .= '<tr>';
				$html .= '<td>'.$i.'</td>';

				$porcentagemP[$i] = intval(($primeiroC[$i] * 100) / $totalP[$i]);
				$porcentagemS[$i] = intval(($segundoC[$i] * 100) / $totalS[$i]);
				$porcentagemT[$i] = intval(($terceiroC[$i] * 100) / $totalT[$i]);

				$html .= '<td id=""'.$uc.'">'.$porcentagemP[$i].'%</td>';
				$html .= '<td id="'.$uc.'">'.$porcentagemS[$i].'%</td>';
				$html .= '<td id="'.$uc.'">' . $porcentagemT[$i] . '%</td>';
			}
		}

		//Configurações header para forçar o download

		/*header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=" . $arquivo);
		header ("Content-Description: PHP Generated Data" );*/

		// Envia o conteúdo do arquivo

		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-Type: application/xls");
		header ("Content-Disposition:attachment; filename=teste.xls");
		header ("Content-Description: PHP Generated Data" );

		echo $html;
		exit;
	?>

</body>
</html>