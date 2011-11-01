function addTicket(){
	showPopUp('#ticketDataPopUp');
}

function getSaldo(){
	var ticket = {
		unidades: $('#ticketDataEditorQuantity').val(),
		duracion: $('#ticketDataEditorDuration').val()
	}

	$.ajax({
		url: "tickets/getValor",
		global: false,
		type: "POST",
		data: {
			'ticket': JSON.stringify(ticket)
		},
		dataType: "json",
		async: true,
		success: function(response){
			$('#ticketDataEditorValue').val("$ "+response.valor);
		},
		error: function(response){
			/*processError(response);*/
			$('#ticketDataEditorValue').val("$ 0");
		}
	});

}

$(document).ready(function(){
	$('#ticketDataEditorQuantity').focus();
	$('#ticketDataEditorQuantity').keyup(function(e){
	    this.value = this.value.replace(/\D/g,'');
	    if(this.value == 0)	this.value = '';
	    getSaldo();
	});
});

/*WINDOW ONLOAD*/
$(function(){
	$('#ticketDataPopUp .sendButton').click(function(){

		var ticket = {
			unidades: $('#ticketDataEditorQuantity').val(),
			duracion: $('#ticketDataEditorDuration').val(),
		};

		$.ajax({
			url: "tickets/add",
			global: false,
			type: "POST",
			data: {
				'ticket': JSON.stringify(ticket)
			},
			dataType: "json",
			async: true,
			success: function(response){
				//alert("Se han guardado los datos");
				hidePopUp();
				//TODO this is so ugly we shouldnt reload all the page.
				window.location.reload();
			},
			error: function(response){
				processError(response);
			}
		});
		
	});

	return false;
});