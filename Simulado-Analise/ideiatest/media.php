<?php 
	
	session_start();
	
?>

<?php 
	
	$con = mysqli_connect("localhost", "root", "", "simulado")or die("Não conectou");

	mysqli_query($con, "SET NAMES utf8");

	$amareloID = 0;
	$azul = 0;
	$

	$sql = "SELECT * from simcadernos
			join simcadquestoes on simcadquestoes.simcaderno_id = simcadernos.id
			join simquestoes on simquestoes.id = simcadquestoes.simquestao_id
			group by simcadernos.cor, simcadernos.created";

}