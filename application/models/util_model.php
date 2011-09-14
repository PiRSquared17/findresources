<?php
class Util_model extends FR_Model {
	
	function Util_model() 
	{
		parent::__construct();
	}
	
	/**
	 * Busca en la db los estados civiles disponibles.
	 * @author martin.fox
	 * @param
	 * @return array[id] = [{descripcion}]
	 * */
	public function  getEstadosCiviles(){
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':po_salida', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_estado_civil',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_salida");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->estado_civil] = $dbRegistro->d_estado_civil;
			}
			return $response;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message in getEstadosCiviles(): ' . $n2);
		}
	}
	
	/**
	 * Busca en la db los paises disponibles.
	 * @author martin.fox
	 * @param
	 * @return array[id]  [{descripcion}]
	 */
	public function  getPaises(){
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':po_paises', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_paises',$params);
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_paises");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->pais] = $dbRegistro->dpais;
			}
			
			return $response;
		}
		else{
			
			/** CERRAR LA CONEXI�N A LA BASE **/ 
			//TODO exception managment.
        	throw new Exception('Oracle error message in getPaises(): ' . $n2);
		}
	}
	
	/**
	/**
	 * Busca en la db las provincias de un pais.
	 * @author martin.fox
	 * @param idPais
	 * @return array[id] =  [{descripcion}]
	 */
	public function  getProvincias($idPais){

		/** LOAD DATABASE **/
//		$this->load->database();		
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
//		array('name'=>':PI_ID_PAIS', 'value'=>$idPais, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_salida', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_provincias',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_salida");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->provincias] = $dbRegistro->d_provincias;
			}
			
			return $response;
		}
		else{
			
			//TODO exception managment.
        	throw new Exception('Oracle error message in getProvincias(): ' . $n2);
		}
	
	}

	/**
	 * Devuelve las habilidades diponibles para seleccionar.
	 * @return array[id] = [{descripcion}]
	 * */
	public function  getIndustriasDisponibles(){
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':po_salida', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_industrias',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_salida");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->id_industria] = $dbRegistro->d_industria;
			}
			
			return $response;
		}
		else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in getIndustriasDisponibles(): ' . $n2);
		}
		
	}

	/**
	 * Devuelve las herramientas de un determinado rubro.
	 * Recibe por post el rubro correspondiente.
	 * @param idArea
	 * @return array[id] = [descripction}]
	 * */
	public function  getHerramientasPorArea($idArea){
//		$respuesta[0]->id = 1; 
//		$respuesta[0]->descripcion = "Java";
//		$respuesta[1]->id = 2; 
//		$respuesta[1]->descripcion = ".Net";
//		$respuesta[2]->id = 3; 
//		$respuesta[2]->descripcion = "Oracle";
//		return $respuesta; ///not in the db yet.
//		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':pi_area', 'value'=>$idArea, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':pi_id_herramienta', 'value'=>null, 'type'=>SQLT_CHR, 'length'=>-1),
		array('name'=>':po_herramientas', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_herramientas',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_herramientas");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->id_herramienta] = $dbRegistro->d_herramienta;
			}
			
			return $response;
		}
		else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in getHerramientasPorArea(): ' . $n2);
		}		
		
		
	}

	/**
	 * Busca los niveles de educacion disponibles
	 * @param
	 * @return array with id and descripcion array[id] [{descripcion}]
	 * */
	public function  getNivelesDeEducacion(){
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':po_niveles_educacion', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_niveles_educacion',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_niveles_educacion");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->nivel_educacion] = $dbRegistro->d_nivel_educcacion;
			}
			
			return $response;
		}
		else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in getNivelesDeEducacion(): ' . $n2);
		}
		
	}	

	/**
	 * Devuelve las habilidades diponibles para seleccionar.
	 * @return [{id, descripcion}]
	 * */
	public function  getAreasDisponibles(){
		
		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':po_areas', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_areas',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_areas");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->id_area] = $dbRegistro->d_area;
			}
			
			return $response;
		}
		else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in getAreasDisponibles(): ' . $n2);
		}
		
	}
	
	/**
	 * Devuelve las entidades educativas conocidas
	 * @return [{id, descripcion}]
	 * */
	public function  getEntidadesEducativas(){

		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':po_entidades', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_entidad_educativa',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_entidades");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->id_entidad_educativa] = $dbRegistro->d_entidad_educativa;
			}
			
			return $response;
		}
		else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in getEntidadesEducativas(): ' . $n2);
		}
		
	}	
	
	
	
	/**
	 * Devuelve los tipos de educacion no formal disponibles
	 * @return array[id] = [descripcion]
	 * */
	public function  getTiposDeEducacionNoFormal(){

		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':po_tipo_edu_no_formal', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_tipo_edu_no_formal',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_tipo_edu_no_formal");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->tipo_educacion_no_formal] = $dbRegistro->d_tipo_educacion_no_formal;
			}
			
			return $response;
		}
		else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in getEntidadesEducativas(): ' . $n2);
		}
		
	}		
	

	/**
	 * Devuelve los tipos de educacion no formal disponibles
	 * @return array [id] = [{descripcion}]
	 * */
	
	public function  getTiposDeDocumentos(){

		$curs=NULL;
		$n1 = NULL;
		$n2 = NULL;
		$params = array(
		array('name'=>':po_documentos', 'value'=>&$curs, 'type'=>SQLT_RSET , 'length'=>-1),
		array('name'=>':po_c_error', 'value'=>&$n1, 'type'=>SQLT_CHR , 'length'=>255),
		array('name'=>':po_d_error', 'value'=>&$n2, 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'pkg_util','pr_obtiene_tipos_documentos',$params);
		
		if ($n1 == 0){
			$dbRegistros = $this->oracledb->get_cursor_data(":po_documentos");
			//$dbRegistros = $this->decodeCursorData($dbRegistros);
			
			//convert db data to model data.
			$response = array();
			foreach ($dbRegistros as $i => $dbRegistro){
				$response[$dbRegistro->tipodocumento] = $dbRegistro->dtipodocumneto;
			}
			
			return $response;
		}
		else{
			//TODO exception managment.
        	throw new Exception('Oracle error message in getTiposDeDocumentos(): ' . $n2);
		}
		
	}

	
	/** OBTENGO HABILIDADES BLANDA **/
	public function  getHabilidadesBlandas($idHabilidad){
		
		$result["habilidadesBlandas"] = NULL;
		$result["error"] = NULL;
		$result["desc"] = NULL;
		
		$params = array(
			array('name'=>':PI_ID_HABILIDAD_BLANDA', 'value'=>$idHabilidad, 'type'=>SQLT_CHR, 'length'=>-1),
			array('name'=>':PO_LISTA_HAB_BLANDAS', 'value'=>&$result["habilidadesBlandas"], 'type'=>SQLT_RSET, 'length'=>255),
			array('name'=>':PO_C_ERROR', 'value'=>&$result["error"], 'type'=>SQLT_CHR , 'length'=>255),
			array('name'=>':PO_D_ERROR', 'value'=>&$result["desc"], 'type'=>SQLT_CHR, 'length'=>255)
		);
		
		$this->oracledb->stored_procedure($this->db->conn_id,'PKG_UTIL','PR_OBTIENE_HAB_BLANDAS',$params);
		$result["habilidadesBlandas"] = $this->oracledb->get_cursor_data(":PO_LISTA_HAB_BLANDAS");
		return $result;
		
			
	}


}

?>
