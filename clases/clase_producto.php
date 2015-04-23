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
		private $lcPrecioCompra;
		private $lcExistencia;
		private $lnIdTipoProducto;
		private $lcObservacion;
		private $lcEstatus;

		private $lnIdDocumento;
		private $ldFechaEmision;
		private $ldFechaVencimiento;
		private $lcDirectorio;

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

		function set_PrecioCompra($pc)
		{
			$this->lcPrecioCompra=$pc;
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

		function set_Documento($pc)
		{
			$this->lnIdDocumento=$pc;
		}

		function set_FechaEmision($pc)
		{
			$this->ldFechaEmision=$pc;
		}

		function set_FechaVencimiento($pc)
		{
			$this->ldFechaVencimiento=$pc;
		}

		function set_Directorio($pc)
		{
			$this->lcDirectorio=$pc;
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


		function consultar_ultimos_productos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT tproducto.idproducto, descripcioncortapro, estatuspro, count(tfactura_producto.tproducto_idproducto) cantidad_facturas, sum(tfactura_producto.cantidadpro) cantidad_total, unidadmedidapro  FROM tproducto, tfactura_producto WHERE tfactura_producto.tproducto_idproducto = idproducto GROUP BY idproducto, descripcioncortapro, estatuspro, unidadmedidapro ORDER BY cantidad_facturas DESC LIMIT 5;";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;					
					$Fila[$cont]['cantidad_total']= number_format(round($laRow['cantidad_total']));					
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
            observacionpro, estatuspro,RTRIM(unidadmedidapro,' ')as unidadmedidapro,preciocomprapro FROM tproducto,ttipo_producto WHERE idproducto='$this->lnIdProducto' AND ttipo_producto_idtipo_producto=idtipo_producto";
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
			$this->begin();
			$sql="INSERT INTO tproducto ( idcodigopro, descripcioncortapro, descripcionlargapro, 
            unidadmedidapro, preciounitariopro, existenciapro, ttipo_producto_idtipo_producto, 
            observacionpro, estatuspro,preciocomprapro)VALUES(UPPER('$this->lcIdCodigo'),UPPER('$this->lcDescripcioncorta'),UPPER('$this->lcDescripcionlarga'),'$this->lcUnidadMedida','$this->lcPrecioUnitario','$this->lcExistencia','$this->lnIdTipoProducto',UPPER('$this->lcObservacion'),'1','$this->lcPrecioCompra')";
				if($lnHecho=$this->ejecutar($sql))
				{
					for($i=0;$i<count($this->lnIdDocumento);$i++)
					{
						$sql="INSERT INTO tproducto_documento(tproducto_idproducto, tdocumento_iddocumento, fechaemisiondoc, fechavencimientodoc, directoriodoc, estatusdoc)VALUES ((SELECT MAX(idproducto) FROM tproducto LIMIT 1),".$this->lnIdDocumento[$i].", '".$this->fecha_bd($this->ldFechaEmision[$i])."', '".$this->fecha_bd($this->ldFechaVencimiento[$i])."', '".$this->lcDirectorio[$i]."', '1')";
						if(!$lnHecho=$this->ejecutar($sql))
						{
							$this->rollback();
							break;
						}
					}
				}
				if($lnHecho)
					$this->commit();
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
			$this->begin();
			$sql="UPDATE tproducto SET idcodigopro=UPPER('$this->lcIdCodigo'),descripcioncortapro=UPPER('$this->lcDescripcioncorta'),descripcionlargapro=UPPER('$this->lcDescripcionlarga'),unidadmedidapro='$this->lcUnidadMedida',preciounitariopro='$this->lcPrecioUnitario',existenciapro='$this->lcExistencia',ttipo_producto_idtipo_producto='$this->lnIdTipoProducto',observacionpro=UPPER('$this->lcObservacion'),preciocomprapro='$this->lcPrecioCompra' WHERE idproducto='$this->lnIdProducto' ";
			if($lnHecho=$this->ejecutar($sql))
			{
				$sql="DELETE FROM tproducto_documento WHERE tproducto_idproducto='$this->lnIdProducto' ";
				if(!$lnHecho=$this->ejecutar($sql))
				{
					$this->rollback();
							break;
				}
				else
				{
					for($i=0;$i<count($this->lnIdDocumento);$i++)
					{
						$sql="INSERT INTO tproducto_documento(tproducto_idproducto, tdocumento_iddocumento, fechaemisiondoc, fechavencimientodoc, directoriodoc, estatusdoc)VALUES ('$this->lnIdProducto',".$this->lnIdDocumento[$i].", '".$this->fecha_bd($this->ldFechaEmision[$i])."', '".$this->fecha_bd($this->ldFechaVencimiento[$i])."', '".$this->lcDirectorio[$i]."', '1')";
						if(!$lnHecho=$this->ejecutar($sql))
						{
							$this->rollback();
							break;
						}
					}
				}
			}
			if($lnHecho)
				$this->commit();

			$this->desconectar();
			return $lnHecho;
		}
	}
?>