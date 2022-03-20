$(function(){

	$("#btnEnvie").click(clickBusca);

});

function clickBusca(){

	alert($("#txtDia").val());

	$.ajax({
		url: "busca.php?ano=" + $("#txtAno").val() + "&&cor=" + $("#txtCor").val(),
		method: "get",
		success: function(busca){
			$("#conteudo").html(busca);
		}
	});
}