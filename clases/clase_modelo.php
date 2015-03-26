<?php

/**
 *CREATE TABLE tmodelo
 *(
 * idmodelo bigint NOT NULL DEFAULT nextval('sidmodelo'::regclass),
 * descripcionmod character varying(255) NOT NULL,
 * tmarca_idmarca bigint NOT NULL,
 * observacionmod character varying(255),
 * estatusmod character(1) NOT NULL,
 */
	require_once('../nucleo/ModeloConectPg.php');
	class clsModelo extends clsModelo_pg
	{
		private $lnIdModelo;
		private $lcDescripcionmod;
		private $lnMarca;
		private $lcObservacion;
		private $lcEstatus;

		function set_Modelo($pc)
		{
			$this->lnIdModelo=$pc;
		}

		function set_Descripcion($pc)
		{
			$this->lcDescripcionmod=$pc;
		}

		function set_Marca($pc)
		{
			$this->lnMarca=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
		{
			$this->lcEstatus=($pc) ? $pc : '1';
		}


		function consultar_modelos()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT tmodelo.*, tmarca.descripcionmar FROM tmodelo, tmarca WHERE tmarca.idmarca = tmodelo.tmarca_idmarca;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;					
				$Fila[$cont]['estatus_color']=($laRow['estatusmod'])?'success':'danger';
				$Fila[$cont]['estatusmod'] = ($laRow['estatusmod']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatusmod']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatusmod']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatusmod']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatusmod']) ? 'times' : 'refresh';					
				$cont++;
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_modelos_marca()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT tmodelo.*, tmarca.descripcionmar FROM tmodelo, tmarca WHERE tmarca.idmarca = '$this->lnMarca' AND tmodelo.tmarca_idmarca = tmarca.idmarca;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;					
				$Fila[$cont]['estatus_color']=($laRow['estatusmod'])?'success':'danger';
				$Fila[$cont]['estatusmod'] = ($laRow['estatusmod']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatusmod']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatusmod']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatusmod']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatusmod']) ? 'times' : 'refresh';					
				$cont++;
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_modelo()
		{
			$this->conectar();
			$sql="SELECT tmodelo.* tmarca.descripcionmar FROM todelo, tmarca WHERE idmodelo='$this->lnIdModelo' AND tmarca.idmarca = tmodelo.tmarca_idmarca;";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
			}
			$this->desconectar();
			return $Fila;
		}

		function registrar_modelo()
		{
			$this->conectar();
				$sql="INSERT INTO tmodelo(
					            descripcionmod, tmarca_idmarca, observacionmod, estatusmod)
					    VALUES (UPPER('$this->lcDescripcionmod'), '$this->lnMarca', UPPER('$this->lcObservacion'), '$this->lcEstatus');";
				$lnHecho=$this->ejecutar($sql);

			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_modelo()
		{
			$this->conectar();
			$sql="UPDATE tmodelo SET estatusmod='0' WHERE idmodelo='$this->lnIdModelo';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_modelo()
		{
			$this->conectar();
			$sql="UPDATE tmodelo SET estatusmod='1' WHERE idmodelo='$this->lnIdModelo';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_modelo()
		{
			$this->conectar();
			$sql="UPDATE tmodelo
				   SET descripcionmod=UPPER('$this->lcDescripcionmod'), tmarca_idmarca='$this->lnMarca', observacionmod=UPPER('$this->lcObservacion')
				 WHERE idmodelo = '$this->lnIdModelo';";
			echo $sql;
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>