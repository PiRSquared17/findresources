<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<body>
<script type="text/javascript" src=" <?php echo site_url('js/jquery-1.6.2.min.js')?>"></script>
<script type="text/javascript" src=" <?php echo site_url('js/json2.js')?>"></script>

<script type="text/javascript">
	$(function(){
		$('#cvEditorButton').click(function(){

			var curriculum = {
				'gtalk': $('gtalk').val(),
				'usuario':"unmail@unserver.com",
				'estadoCivil':0,
				'fechaNacimiento':"1998/05/31:12:00:00AM",
				'idPais':0,
				'idProvincia':0,
				'partido':"Ramos Mejia",
				'calle':"Calle Falsa",
				'numero':"2222",
				'piso':"3",
				'departamento':"A",
				'codigoPostal':"CWI1417C",
				'telefono1':$('telefono1').val(),
				'horarioContactoDesde1':"9",
				'horarioContactoHasta1':"18",
				'telefono2':"4554-1235",
				'horarioContactoDesde2':"",
				'horarioContactoHasta2':"",
				'nacionalidad':"Argentino",
				'twitter': "@twitteruser",
				'sms': "15-3838-4994"
			};
			
			$.post("curriculum/setCurriculum", {
					'curriculum': JSON.stringify(curriculum)
				},
			function(response){
				debugger;
				//response == 0 is ok
			},
			"json");
			
		});
		
		$('#getProvincias').click(function(){
			$.post("curriculum/getProvincias", {
				'idPais': 0
			},
			function(provincias){
				debugger;
				alert(provincias[0].descripcion);
			},
			"json");
		});

		var habilidades = [
	     	{
	    	 	idHabilidad: 0,
	    	 	tipoHabilidad: 0,
	    	 	puntajeHabilidad: 3
	    	},
	     	{
	    	 	idHabilidad: 0,
	    	 	tipoHabilidad: 1,
	    	 	puntajeHabilidad: 2
	    	},
	     	{
	    	 	idHabilidad: 2,
	    	 	tipoHabilidad: 1,
	    	 	puntajeHabilidad: 2
	    	}
	    ];
    
		
		$('#setHabilidades').click(function(){
			$.post("curriculum/setHabilidadesDelCV", {
				'habilidades': JSON.stringify(habilidades)
			},
			function(data){
				debugger;
			},
			"json");
		});
		
		

		
		return false;
	});
</script>

un cv <br/>
<?php 
	echo $curriculumData->id;
	echo '<br/>';
	echo $curriculumData->usuario;
	echo '<br/>';
	foreach ($estadosCiviles as $unEstadoCivil){
		if($unEstadoCivil->id == $curriculumData->estadoCivil){
			echo $unEstadoCivil->descripcion;
		}
	}
	echo '<br/>';
	echo $curriculumData->fechaNacimiento;
	echo '<br/>';
	echo $curriculumData->idPais;
	echo '<br/>';
	echo $curriculumData->idProvincia;
	echo '<br/>';
	echo $curriculumData->partido;
	echo '<br/>';
	echo $curriculumData->calle;
	echo '<br/>';
	echo $curriculumData->numero;
	echo '<br/>';
	echo $curriculumData->piso;
	echo '<br/>';
	echo $curriculumData->departamento;
	echo '<br/>';
	echo $curriculumData->codigoPostal;
	echo '<br/>';
	echo $curriculumData->telefono1;
	echo '<br/>';
	echo $curriculumData->horarioContactoDesde1;
	echo '<br/>';
	echo $curriculumData->horarioContactoHasta1;
	echo '<br/>';
	echo $curriculumData->telefono2;
	echo '<br/>';
	echo $curriculumData->horarioContactoDesde2;
	echo '<br/>';
	echo $curriculumData->horarioContactoHasta2;
	echo '<br/>';
	echo $curriculumData->nacionalidad;
	echo '<br/>';
	echo $curriculumData->twitter;
	echo '<br/>';
	echo $curriculumData->gtalk;
	echo '<br/>';
	echo $curriculumData->sms;
	echo '<br/>';
?>
	<H1>HABILIDADES DEL CV</H1>
<?php 
	foreach ($habilidadesDelCV as $habilidad){
		echo ' TIPO 0 es industria 1 herramienta>'. $habilidad->tipo . ' idIndustria/idHerramienta' . $habilidad->id . ' ' . $habilidad->puntaje . '<br/>' ;
	}
?>

	<H1>EXPERIENCIA LABORAL DEL CV</H1>
<?php 
	foreach ($experienciaLaboralDelCv as $experiencia){
		echo $experiencia->id . ' ' . $experiencia->compania . ' ' . $experiencia->idRubro . ' ' . $experiencia->idPais . ' ' .  $experiencia->fechaDesde . ' ' .  $experiencia->fechaHasta . ' ' .  $experiencia->logro;
	}
?>


	<H1>ESTADOS CIVILES DISPONIBLES</H1>
<?php 
	function imprimirArrayConDescripciones($array){
		foreach ($array as $item){
			echo $item->id . ' ';
			echo $item->descripcion;
			echo '<br/>';
		}
		
	}
	imprimirArrayConDescripciones($estadosCiviles);
?>
	<H1>PAISES</H1>
<?php 
	imprimirArrayConDescripciones($paises);
?>
	<H1>INDUSTRIAS DISPONIBLES</H1>
<?php 
	imprimirArrayConDescripciones($industriasDisponibles);
?>

	<H1>RUBROS DISPONIBLES</H1>
<?php 
	imprimirArrayConDescripciones($rubrosDisponibles);
?>



<div id="cvEditorForm">
	<div>
		<label>gtalk:</label>
		<input type="text" id="gtalk" name="gtalk" />
		<br />
		<label>telefono1:</label>
		<input type="text" id="telefono1" name="telefono1" />
	</div>
	<input type="submit" value="actualizate" id="cvEditorButton"  />
	<input type="submit" value="GET_PROVINCIAS" id="getProvincias"  />
	<input type="submit" value="SET_HABILIDADES" id="setHabilidades"  />
</div>

</body>
</html>
