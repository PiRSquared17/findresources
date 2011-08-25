<?php
class Curriculum_model extends FR_Model {
	
	function Curriculum_model() 
	{
		parent::__construct();
	}
	
	/**
	 * retorna el cv del usuaro, proximamente la lista de cvs del usuario
	 * @param idUsuario
	 * @return idCurriculum.
	 * */
	public function getCurriculumUser($idUsuario){
		
		$rta=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_usuario', 'value'=>$idUsuario, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_id_curriculum', 'value'=>&$rta, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_obtengo_id_curriculum',$params);
		
		if ($n1 == 0){
			return $rta;
		}else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in getCurriculumUser('. $idUsuario .'): ' . $n2);
		}
		
	}
	
	/**
	 * retorna el cv del usuaro, proximamente la lista de cvs del usuario
	 * @param idUsuario
	 * @return idCurriculum.
	 * */
	public function createCurriculumUser($idUsuario){
		
		$rta=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_usuario', 'value'=>$idUsuario, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_id_curriculum', 'value'=>&$rta, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_crea_cv',$params);
		
		if ($n1 == 0){
			return $rta;
		}else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in createCurriculumUser('. $idUsuario . ')'. $n2);
		}
		
	}	
	
	/**
	 * @param idCurriculum
	 * @return {'gtalk', 'usuario', 'estadoCivil', 'fechaNacimiento':"1998/05/31:12:00:00AM",
	 *      'idPais','idProvincia','partido','calle',
	 *      'numero','piso','departamento','codigoPostal',
	 *      'telefono1','horarioContactoDesde1','horarioContactoHasta1','telefono2',
	 *      'horarioContactoDesde2','horarioContactoHasta2','idPaisNacionalidad','twitter','gtalk','sms'
	 *      }
	 * **/
	public function  getCurriculum($idCurriculum){
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculm', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_cv', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_consulta_cv',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data();
			$dbRegistros = $this->decodeCursorData($dbRegistros);
			//convert db data to model data.
			$response->id = $idCurriculum;
			$response->usuario = $dbRegistros[0]->usuario;
			$response->estadoCivil = $dbRegistros[0]->estado_civil;
			//$response->cantidadHijos = 0;
			$response->fechaNacimiento = $dbRegistros[0]->fecha_nacimiento;
			$response->idPais = $dbRegistros[0]->pais;
			$response->idProvincia = $dbRegistros[0]->provincia;
			$response->partido = $dbRegistros[0]->partido;
			$response->calle = $dbRegistros[0]->calle;
			$response->numero = $dbRegistros[0]->numero;
			$response->piso = $dbRegistros[0]->piso;
			$response->departamento = $dbRegistros[0]->departamento;
			$response->codigoPostal = $dbRegistros[0]->codigo_postal;
			$response->telefono1 = $dbRegistros[0]->telefono_contacto1;
			$response->horarioContactoDesde1 = $dbRegistros[0]->horario_contacto1_desde1;
			$response->horarioContactoHasta1 = $dbRegistros[0]->horario_contacto1_hasta1;
			$response->telefono2 = $dbRegistros[0]->telefono_contacto2;
			$response->horarioContactoDesde2 = $dbRegistros[0]->horario_contacto2_desde;
			$response->horarioContactoHasta2 = $dbRegistros[0]->horario_contacto2_hasta;
			$response->idPaisNacionalidad = $dbRegistros[0]->nacionalidad;
			$response->twitter = $dbRegistros[0]->twitter;
			$response->gtalk = $dbRegistros[0]->gtalk;
			$response->sms = $dbRegistros[0]->sms;
			
			return $response;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: getCurriculum('.$idCurriculum. ')' . $n2);
		}		
		
	}

	/**
	 * @param unCurriculum: {'gtalk', 'usuario', 'estadoCivil', 'fechaNacimiento':"1998/05/31:12:00:00AM",
	 *      'idPais','idProvincia','partido','calle',
	 *      'numero','piso','departamento','codigoPostal',
	 *      'telefono1','horarioContactoDesde1','horarioContactoHasta1','telefono2',
	 *      'horarioContactoDesde2','horarioContactoHasta2','idPaisNacionalidad','twitter', 'gtalk','sms'
	 *      }
	 * @return 0 is Ok
	 * */
	public function  setCurriculum($unCurriculum){
		
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculm', 'value'=>$unCurriculum->id, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_estado_civil', 'value'=>$unCurriculum->estadoCivil, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_cantidad_hijos', 'value'=>0, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_fecha_nacimiento', 'value'=>$unCurriculum->fechaNacimiento, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_pais', 'value'=>$unCurriculum->idPais, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_provincia', 'value'=>$unCurriculum->idProvincia, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_partido', 'value'=>$unCurriculum->partido, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_calle', 'value'=>$unCurriculum->calle, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_numero', 'value'=>$unCurriculum->numero, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_piso', 'value'=>$unCurriculum->piso, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_departamento', 'value'=>$unCurriculum->departamento, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_codigo_postal', 'value'=>$unCurriculum->codigoPostal, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_telefono_contacto1', 'value'=>$unCurriculum->telefono1, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_horario_contacto1_desde1', 'value'=>$unCurriculum->horarioContactoDesde1, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_horario_contacto1_hasta1', 'value'=>$unCurriculum->horarioContactoHasta1, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_telefono_contacto2', 'value'=>$unCurriculum->telefono2, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_horario_contacto2_desde', 'value'=>$unCurriculum->horarioContactoDesde2, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_horario_contacto2_hasta', 'value'=>$unCurriculum->horarioContactoHasta2, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_nacionalidad', 'value'=>$unCurriculum->idPaisNacionalidad, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_twitter', 'value'=>$unCurriculum->twitter, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_gtalk', 'value'=>$unCurriculum->gtalk, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_sms', 'value'=>$unCurriculum->sms, 'type'=>SQLT_CHR, 'length'=>-1),	
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_actualiza_cv',$params);
		
		if ($n1 == 0){
			return 0;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}		
		
	}
	
	/**
	 * Obtiene la lista de habilidades del tipo industria del cv.
	 * @param idCurriculum
	 * @return habilidades [{idIndustria, puntos}]
	 * 
	 * */
	public function  getHabilidadesIndustriasDelCV($idCurriculum){
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculum', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_industrias_cv', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_consulta_industria',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data();
			$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$respuesta = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$respuesta[$i]->idIndustria = $dbRegistro->id_industria;
				$respuesta[$i]->descripcionIndustria = "descripcion".$dbRegistro->id_industria; //$dbRegistro->d_industria;
				$respuesta[$i]->puntos = $dbRegistro->valoracion;
			}
			return $respuesta;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}				
		
		
	}

	/**
	 * Ingresar la lista de habilidades del tipo industria del cv.
	 * @param idCurriculum a editar
	 * @param habilidades [{idIndustria, puntos}]
	 * @return 
	 * */
	public function  setHabilidadesIndustriasDelCV($idCurriculum, $habilidades){
		
		$parametro = "";
		foreach ($habilidades as $habilidad){
//			if($parametro != ""){
//				//Its not the first need add ;
//				$parametro = $parametro . ';'; 
//			}
			$parametro = $parametro . 
					$habilidad->idIndustria . ';' . 
					$habilidad->puntos . ';';
		}
		
//		return 0; //not in db yet
		echo " <". $idCurriculum. "   ". $parametro . "         >" ;
		return 0;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculm', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_industria_cv', 'value'=>$parametro, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_actualiza_industria',$params);
		
		if ($n1 == 0){
			return 0;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}
				
		
	}
		
	
	/**
	 * Obtiene la lista de habilidades del tipo area del cv.
	 * @param idCurriculum a editar
	 * @param habilidades [{idArea, idHerramienta, puntos}]
	 * 
	 * */
	public function  getHabilidadesAreasDelCV($idCurriculum){
		$respuesta[0]->idArea = 0;
		$respuesta[0]->descripcionArea = "Inform�tica";
		$respuesta[0]->idHerramienta = 0;
		$respuesta[0]->descripcionHerramienta = "Java Script";
		$respuesta[0]->puntos = 5;
		
		$respuesta[1]->idArea = 0;
		$respuesta[1]->descripcionArea = "Dise�o";
		$respuesta[1]->idHerramienta = 2;
		$respuesta[1]->descripcionHerramienta = "Photoshop";
		$respuesta[1]->puntos = 1;
		
		return $respuesta; //not in db yet
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculum', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_habilidades_duras_industria', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_obtiene_habilidades_duras_areas',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data();
			$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$respuesta = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$respuesta[$i]->idArea = $dbRegistro->id_area;
				$respuesta[$i]->descripcionArea = $dbRegistro->d_area;
				$respuesta[$i]->idHerramienta = $dbRegistro->id_herramienta;
				$respuesta[$i]->descripcionHerramienta = $dbRegistro->d_herramienta;
				$respuesta[$i]->puntos = $dbRegistro->puntos;
			}
			return $respuesta;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}		
	}	

	/**
	 * Ingresar la lista de habilidades del tipo area.
	 * @param idCurriculum a editar
	 * @param habilidades [{idArea, idHerramienta, puntos}]
	 * */
	public function  setHabilidadesAreasDelCV($idCurriculum, $habilidades){
		$parametro = "";
		foreach ($habilidades as $habilidad){
//			if($parametro != ""){
//				//Its not the first need add ;
//				$parametro = $parametro . ';'; 
//			}
			$parametro = $parametro .  
					$habilidad->idArea . ';' . 
					$habilidad->idHerramienta . ';' . 
					$habilidad->puntos  . ';';
		}
		
		return 0; //NOT IN DB YET ////////////

		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculm', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_habilidades_duras_areas', 'value'=>$parametro, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','actualiza_habilidades_duras_areas',$params);
		
		if ($n1 == 0){
			return 0;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}
		
	}	
	
	/**
	 * @param: idCurriculum
	 * @return: array with [{id, compania, idIndustria, idPais, fechaDesde, fechaHasta, logro}]
	 */
	public function  getExperienciaLaboralDelCv($idCurriculum){
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculm', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_exp_laboral', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_consulta_exp_laboral',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data();
			$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$i]->id  = $dbRegistro->id_historia_laboral_cv;
				$response[$i]->compania = $dbRegistro->d_compania;
				$response[$i]->idIndustria = $dbRegistro->id_industria;
				$response[$i]->idPais = $dbRegistro->pais;
				$response[$i]->fechaDesde = $dbRegistro->f_desde;//formato DD/MM/YYYY
				$response[$i]->fechaHasta = $dbRegistro->f_hasta; //formato DD/MM/YYYY
				$response[$i]->logro = $dbRegistro->d_logro;
			}
			return $response;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}				
		
	}

	/**
	 * @param $idCurriculum
	 * @param $experienciaLaboral {id, compania, idIndustria, idPais, fechaDesde, fechaHasta, logro}
 	 * para nuevo registro, $experienciaLaboral->id debe ser nulo.
	 * @return retorna el id de experiencia laboral.
	 * */
	public function setExperienciaLaboral($idCurriculum, $experienciaLaboral){
		$rta=NULL;
		$n1 = NULL;
		$n2 = NULL;
		
		
		$params = array(
		
		array('name'=>':pi_id_historia_laboral_cv', 'value'=>$experienciaLaboral->id, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_id_curriculm', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_d_compania', 'value'=>$experienciaLaboral->compania, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_id_industria', 'value'=>$experienciaLaboral->idIndustria, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_pais', 'value'=>$experienciaLaboral->idPais, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_f_desde', 'value'=>$experienciaLaboral->fechaDesde, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_f_hasta', 'value'=>$experienciaLaboral->fechaHasta, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_d_logro', 'value'=>$experienciaLaboral->logro, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_id_historia_laboral_cv', 'value'=>&$rta, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_actualizo_exp_laboral',$params);
		
		if ($n1 == 0){
			return $rta;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}		
			
	}
	
	/**
	 * @param idCurriculum
	 * @return array of educacionFormal = [{id, idEntidad, descripcionEntidad, titulo, idNivelEducacion, idArea, 
	 * 			estado: "T" terminado "A" abandobado "C" en curso 
	 * 			fechaInicio: "01/01/1900", fechaFinalizacion, promedio: 6.89
	 * 			}]
	 * */
	public function  getEducacionFormalDelCv($idCurriculum){
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculum', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_educacion_formal', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_consulta_edu_formal',$params);
		if ($n1 == 0){
			
			$dbRegistros = $this->oracledb->get_cursor_data();
//			var_dump($dbRegistros);
			$dbRegistros = $this->decodeCursorData($dbRegistros);

			//convert db data to model data.
			$respuesta = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$respuesta[$i]->id = $dbRegistro->id_educacion_formal_cv;
				$respuesta[$i]->idEntidad = $dbRegistro->id_entidad_educativa;
				$respuesta[$i]->descripcionEntidad = $dbRegistro->d_entidad;
				$respuesta[$i]->titulo = $dbRegistro->titulo;
				$respuesta[$i]->idNivelEducacion = $dbRegistro->id_nivel_educacion;
				$respuesta[$i]->idArea = $dbRegistro->id_area;
				$respuesta[$i]->estado = $dbRegistro->estado;
				$respuesta[$i]->fechaInicio = $dbRegistro->f_inicio;
				$respuesta[$i]->fechaFinalizacion = $dbRegistro->f_finalizacion;
				$respuesta[$i]->promedio = $dbRegistro->promedio;
			}
			return $respuesta;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}						
		
	}
	
	/**
	 * @param $idCurriculum
	 * @param $educacionFormal = {id (null for new item), idEntidad, descripcionEntidad,
	 * 			 titulo, idNivelEducacion, idArea, 
	 * 			estado: "T" terminado "A" abandobado "C" en curso 
	 * 			fechaInicio: "01/01/1900", fechaFinalizacion, promedio: 6.89
	 * 			}
	 * @return idEducacionFormal
	 * 		
	 * */
	public function  setEducacionFormal($idCurriculum, $educacionFormal){
		$rta=NULL;
		$n1 = NULL;
		$n2 = NULL;
		
		$params = array(
			array('name'=>':pi_id_educacion_formal_cv', 'value'=>$educacionFormal->id, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_id_curriculm', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_id_entidad_educativa', 'value'=>$educacionFormal->idEntidad, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_d_entidad', 'value'=>$educacionFormal->descripcionEntidad, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_titulo', 'value'=>$educacionFormal->titulo, 'type'=>SQLT_CHR, 'length'=>-1),
	 		array('name'=>':pi_id_nivel_educacion', 'value'=>$educacionFormal->idNivelEducacion, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_id_area', 'value'=>$educacionFormal->idArea, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_estado', 'value'=>$educacionFormal->estado, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_f_inicio', 'value'=>$educacionFormal->fechaInicio, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_f_finalizacion', 'value'=>$educacionFormal->fechaFinalizacion, 'type'=>SQLT_CHR, 'length'=>-1), //DD/MM/YYYY
			array('name'=>':pi_promedio', 'value'=>$educacionFormal->promedio, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':po_id_educacion_formal_cv', 'value'=>&$rta, 'type'=>SQLT_CHR , 'length'=>255),
			array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
			array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_actualizo_edu_formal',$params);
		
		if ($n1 == 0){
			return $rta;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}
			
	}
	
	/**
	 * @param $idCurriculum
	 * @return educacionNoFormal = [{id, idTipoEducacionNoFormal, 
	 * 			descripcion, duracion}]
	 * 		
	 * */
    public function  getEducacionNoFormalDelCv($idCurriculum){
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_id_curriculum', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_educacion_formal', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_consulta_edu_no_formal',$params);
		
		if ($n1 == 0){
			
			$dbRegistros = $this->oracledb->get_cursor_data();
			$dbRegistros = $this->decodeCursorData($dbRegistros);

			//convert db data to model data.
			$respuesta = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				
				$respuesta[$i]->id = $dbRegistro->id_educacion_no_formal;
				$respuesta[$i]->idTipoEducacionNoFormal = $dbRegistro->tipo_educacion_no_formal;
				$respuesta[$i]->descripcion = $dbRegistro->d_educacion_no_formal;
				$respuesta[$i]->duracion = $dbRegistro->d_duracion;
			}
			return $respuesta;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}						
	}
	
	/**
	 * @param $idCurriculum
	 * @param $educacionNoFormal {id (null for new item), idTipoEducacionNoFormal, 
	 * 			descripcion, duracion}
	 * @return $idEducacionNoFormal
	 * */
	public function setEducacionNoFormal($idCurriculum, $educacionNoFormal){
		$rta=NULL;
		$n1 = NULL;
		$n2 = NULL;
		
		$params = array(
			array('name'=>':pi_id_educacion_no_formal', 'value'=>$educacionNoFormal->id, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_id_curriculm', 'value'=>$idCurriculum, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_tipo_educacion_no_formal', 'value'=>$educacionNoFormal->idTipoEducacionNoFormal, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_d_educacion_no_formal', 'value'=>$educacionNoFormal->descripcionEntidad, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':pi_d_duracion', 'value'=>$educacionNoFormal->duracion, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':po_id_educacion_no_formal', 'value'=>&$rta, 'type'=>SQLT_CHR , 'length'=>255),
			array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
			array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_cv','pr_actualizo_edu_formal',$params);
		
		if ($n1 == 0){
			return $rta;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message: ' . $n2);
		}	
	}
	
	
}

?>