$(function() {

	$("#psicotecnicosGrid").flexigrid({
		url: 'informe_psicotecnicos/getPsicotecnicosGrid',
		dataType: 'json',
		colModel : [
			{display: 'Nombre ', name : 'nombre', width : 200, sortable : false, align: 'center'},
			{display: 'Aspectos que obtiene ', name : 'aspectos', width : 423, sortable : false, align: 'center'},
			{display: 'Veces Utilizado', name : 'cuenta', width : 100, sortable : false, align: 'center'},
			{display: 'Ver Revisiones', name : 'ver_propuesta', width : 100, sortable : false, align: 'center'}
		],
		sortname: "orden",
		sortorder: "asc",
		title: 'Psicotecnicos Disponibles',
		rp: 15,
		width: 890,
		height: 500,
		onError: function(response){
			processError(response);
		} 

	}); 

	
	addExportLink("#psicotecnicosGridContainer", "Psicotecnicos Disponibles");
	addExportLink("#propuestasGridContainer", "Revisiones del psicotecnicos");
	
	return false;
});

var propuestasGrid = null;

function showPropose(idPsicotecnico, name){

	if(!propuestasGrid){
	
		propuestasGrid = $("#propuestasGrid").flexigrid({
			url: 'informe_psicotecnicos/getPropuestasGrid?idPsicotecnico=' + idPsicotecnico,
			dataType: 'json',
			colModel : [
				{display: 'Fecha', name : 'fecha', width : 200, sortable : false, align: 'center'},
				{display: 'Entradas', name : 'entradas', width : 200, sortable : false, align: 'center'},
				{display: 'Salida Obtenida', name : 'entradas', width : 200, sortable : false, align: 'center'},
				{display: 'Propuesta de salida', name : 'entradas', width : 200, sortable : false, align: 'center'},
				{display: 'Notas', name : 'entradas', width : 200, sortable : false, align: 'center'}
			],
			sortname: "orden",
			sortorder: "asc",
			title: 'Propuesta de cambio del test ' + name,
			rp: 15,
			width: 760,
			height: 420,
			onError: function(response){
				processError(response);
			} 
		}); 	
		addExportLink("#propuestasGrid", "Informe de revisiones de psicotécnicos.");

	}else{
		$("#propuestasGrid").flexOptions({url: 'informe_psicotecnicos/getPropuestasGrid?idPsicotecnico=' + idPsicotecnico}); 
		$("#propuestasGrid").flexReload(); 
	}

	showPopUp('#propuestasGridPopUp');

}
