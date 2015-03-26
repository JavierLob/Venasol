<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsMarca extends clsModelo_pg
	{
		private $lnIdMarca;
		private $lcDescripcion;
		private $lcObservacion;
		private $lcEstatus;

		function set_Descripcion($pc)
		{
			$this->lcDescripcion=$pc;
		}

		function set_Marca($pc)
		{
			$this->lnIdMarca=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
		{
			$this->lcEstatus=($pc) ? $pc : '1';
		}


		function consultar_marcas()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT * FROM tmarca;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;	
				$Fila[$cont]['observacionmar'] = ($laRow['observacionmar']) ? $laRow['observacionmar'] : 'Ninguna observación';
				$Fila[$cont]['estatus_color']=($laRow['estatusmar'])?'success':'danger';
				$Fila[$cont]['estatusmar'] = ($laRow['estatusmar']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatusmar']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatusmar']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatusmar']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatusmar']) ? 'times' : 'refresh';					
				$cont++;
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_marca()
		{
			$this->conectar();
			$sql="SELECT * FROM tmarca WHERE idmarca='$this->lnIdMarca';";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
			}
			$this->desconectar();
			return $Fila;
		}

		function registrar_marca()
		{
			$this->conectar();
				$sql="INSERT INTO tmarca(descripcionmar, observacionmar, estatusmar)
    						VALUES (UPPER('$this->lcDescripcion'), UPPER('$this->lcObservacion'), '$this->lcEstatus');";
				$lnHecho=$this->ejecutar($sql);

			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_marca()
		{
			$this->conectar();
			$sql="UPDATE tmarca SET estatusmar='0' WHERE idmarca='$this->lnIdMarca';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_marca()
		{
			$this->conectar();
			$sql="UPDATE tmarca SET estatusmar='1' WHERE idmarca='$this->lnIdMarca';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_marca()
		{
			$this->conectar();
			$sql="UPDATE tmarca
				   SET descripcionmar='$this->lcDescripcion', observacionmar='$this->lcObservacion', estatusmar='$this->lcEstatus'
				 WHERE idmarca='$this->lnIdMarca';";
			echo $sql;
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>