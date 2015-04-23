<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsMarca extends clsModelo_pg
	{
		private $lnIdMarca;
		private $lcDescripcion;
		private $lcObservacion;
		private $lcTipo;
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

		function set_Tipo($pc)
		{
			$this->lcTipo=$pc;
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
				$Fila[$cont]['tipomar']=($laRow['tipomar']=='1')?'Vehículo':'Accesorio';	
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

		function consultar_marcas_tipo($tipo)
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT * FROM tmarca WHERE tipomar='$tipo'";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;				
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
				$Fila['checked_veh']=($laRow['tipomar']=='1')?'checked':'';
				$Fila['active_veh']=($laRow['tipomar']=='1')?'active':'';
				$Fila['checked_acc']=($laRow['tipomar']=='0')?'checked':'';
				$Fila['active_acc']=($laRow['tipomar']=='0')?'active':'';
			}
			$this->desconectar();
			return $Fila;
		}

		function registrar_marca()
		{
			$this->conectar();
				$sql="INSERT INTO tmarca(descripcionmar, observacionmar, estatusmar,tipomar)
    						VALUES (UPPER('$this->lcDescripcion'), UPPER('$this->lcObservacion'), '$this->lcEstatus', '$this->lcEstatus');";
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
				   SET descripcionmar=UPPER('$this->lcDescripcion'), observacionmar=UPPER('$this->lcObservacion'), tipomar='$this->lcTipo'
				 WHERE idmarca='$this->lnIdMarca';";
			echo $sql;
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>