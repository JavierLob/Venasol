<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsProducto extends clsModelo_pg
	{
		private $lnIdProducto;
		private $lcIdCodigo;
		private $lcDescripcioncorta;
		private $lcDescripcionlarga;
		private $lcUnidadMedida;
		private $lcPrecioUnitario;
		private $lcExistencia;
		private $lnIdTipoProducto;
		private $lcObservacion;
		private $lcEstatus;

		function set_Producto($pc)
		{
			$this->lnIdProducto=$pc;
		}

		function set_Codigo($pc)
		{
			$this->lcIdCodigo=$pc;
		}

		function set_Descripcioncorta($pc)
		{
			$this->lcDescripcioncorta=$pc;
		}

		function set_Descripcionlarga($pc)
		{
			$this->lcDescripcionlarga=$pc;
		}

		function set_UnidadMedida($pc)
		{
			$this->lcUnidadMedida=$pc;
		}

		function set_PrecioUnitario($pc)
		{
			$this->lcPrecioUnitario=$pc;
		}

		function set_Existencia($pc)
		{
			$this->lcExistencia=$pc;
		}

		function set_IdTipoProducto($pc)
		{
			$this->lnIdTipoProducto=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
		{
			$this->lcEstatus=$pc;
		}


		function consultar_productos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM tproducto";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;					
					$Fila[$cont]['estatus_color']=($laRow['estatuspro'])?'success':'danger';
					$Fila[$cont]['estatuspro'] = ($laRow['estatuspro']) ? 'Activo' : 'Inactivo';
					$Fila[$cont]['titulo'] = ($laRow['estatuspro']) ? 'Desactivar' : 'Restaurar';
					$Fila[$cont]['color_boton'] = ($laRow['estatuspro']) ? 'danger' : 'warning';
					$Fila[$cont]['funcion'] = ($laRow['estatuspro']) ? 'eliminar' : 'restaurar';
					$Fila[$cont]['icono'] = ($laRow['estatuspro']) ? 'times' : 'refresh';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_productos_like($criterio = '')
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT * FROM tproducto WHERE idcodigopro LIKE '%$criterio%' OR UPPER(descripcioncortapro) LIKE UPPER('%$descripcioncortapro%') OR UPPER(descripcionlargapro) LIKE UPPER('%$descripcionlargapro%');";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila.='<a class="suggest-element" data-value="'.$laRow['idproducto'].'" data-precio="'.$laRow['preciounitariopro'].'" data-descripcion="'.$laRow['descripcioncortapro'].'">'.$laRow['descripcioncortapro'].' '.$laRow['preciounitariopro'].'</a><br>';
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_producto()
		{
			$this->conectar();
				$sql="SELECT idproducto,idcodigopro, descripcioncortapro, descripcionlargapro, 
            preciounitariopro, existenciapro, ttipo_producto_idtipo_producto, 
            observacionpro, estatuspro,RTRIM(unidadmedidapro,' ')as unidadmedidapro FROM tproducto,ttipo_producto WHERE idproducto='$this->lnIdProducto' AND ttipo_producto_idtipo_producto=idtipo_producto";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$Fila=$laRow;
					$Fila['selected_kg']=($laRow['unidadmedidapro']=='kg')?'selected':'';										
					$Fila['selected_lts']=($laRow['unidadmedidapro']=='lts')?'selected':'';										
				}
			
			$this->desconectar();
			return $Fila;
		}

		function registrar_producto()
		{
			$this->conectar();
			$sql="INSERT INTO tproducto ( idcodigopro, descripcioncortapro, descripcionlargapro, 
            unidadmedidapro, preciounitariopro, existenciapro, ttipo_producto_idtipo_producto, 
            observacionpro, estatuspro)VALUES('$this->lcIdCodigo','$this->lcDescripcioncorta','$this->lcDescripcionlarga','$this->lcUnidadMedida','$this->lcPrecioUnitario','$this->lcExistencia','$this->lnIdTipoProducto','$this->lcObservacion','1')";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_producto()
		{
			$this->conectar();
			$sql="UPDATE tproducto SET estatuspro='0' WHERE idproducto='$this->lnIdProducto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_producto()
		{
			$this->conectar();
			$sql="UPDATE tproducto SET estatuspro='1' WHERE idproducto='$this->lnIdProducto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_producto()
		{
			$this->conectar();
			$sql="UPDATE tproducto SET idcodigopro='$this->lcIdCodigo',descripcioncortapro='$this->lcDescripcioncorta',descripcionlargapro='$this->lcDescripcionlarga',unidadmedidapro='$this->lcUnidadMedida',preciounitariopro='$this->lcPrecioUnitario',existenciapro='$this->lcExistencia',ttipo_producto_idtipo_producto='$this->lnIdTipoProducto',observacionpro='$this->lcObservacion' WHERE idproducto='$this->lnIdProducto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>