<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsTipoProducto extends clsModelo_pg
	{
		private $lnIdTipoProducto;
		private $lcDescripcion;
		private $lcObservacion;
		private $lcEstatus;

		function set_TipoProducto($pc)
		{
			$this->lnIdTipoProducto=$pc;
		}

		function set_Descripcion($pc)
		{
			$this->lcDescripcion=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
		{
			$this->lcEstatus=$pc;
		}


		function consultar_tipo_productos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM ttipo_producto";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;					
					$Fila[$cont]['estatus_color']=($laRow['estatustip'])?'success':'danger';
					$Fila[$cont]['estatustip'] = ($laRow['estatustip']) ? 'Activo' : 'Inactivo';
					$Fila[$cont]['titulo'] = ($laRow['estatustip']) ? 'Desactivar' : 'Restaurar';
					$Fila[$cont]['color_boton'] = ($laRow['estatustip']) ? 'danger' : 'warning';
					$Fila[$cont]['funcion'] = ($laRow['estatustip']) ? 'eliminar' : 'restaurar';
					$Fila[$cont]['icono'] = ($laRow['estatustip']) ? 'times' : 'refresh';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_tipo_productos_producto()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM ttipo_producto";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;					
					$Fila[$cont]['selected']=($laRow['idtipo_producto']==$this->lnIdTipoProducto)?'selected':'';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_tipo_producto()
		{
			$this->conectar();
				$sql="SELECT * FROM ttipo_producto WHERE idtipo_producto='$this->lnIdTipoProducto'";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$Fila=$laRow;					
				}
			
			$this->desconectar();
			return $Fila;
		}

		function registrar_tipo_producto()
		{
			$this->conectar();
			$sql="INSERT INTO ttipo_producto (descripciontip,observaciontip,estatustip)VALUES(UPPER('$this->lcDescripcion'),UPPER('$this->lcObservacion'),'1')";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_tipo_producto()
		{
			$this->conectar();
			$sql="UPDATE ttipo_producto SET estatustip='0' WHERE idtipo_producto='$this->lnIdTipoProducto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_tipo_producto()
		{
			$this->conectar();
			$sql="UPDATE ttipo_producto SET estatustip='1' WHERE idtipo_producto='$this->lnIdTipoProducto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_tipo_producto()
		{
			$this->conectar();
			$sql="UPDATE ttipo_producto SET descripciontip=UPPER('$this->lcDescripcion'),observaciontip=UPPER('$this->lcObservacion') WHERE idtipo_producto='$this->lnIdTipoProducto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>