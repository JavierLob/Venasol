<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsFactura extends clsModelo_pg
	{
		private $lnIdFactura;
		private $lnVehiculo;
		private $lnAccesorio;
		private $lnCliente;
		private $lnChofer;
		private $lnIva;
		private $lnTotal;
		private $lcObervacion;
		private $lcEstatus;
		private $lcPorcentajeIva;

		function set_Factura($pc)
		{
			$this->lnIdFactura=$pc;
		}

		function set_Vehiculo($pc)
		{
			$this->lnVehiculo=$pc;
		}

		function set_Accesorio($pc)
		{
			$this->lnAccesorio=$pc;
		}

		function set_Cliente($pc)
		{
			$this->lnCliente=$pc;
		}

		function set_Chofer($pc)
		{
			$this->lnChofer=$pc;
		}

		function set_Iva($pc)
		{
			$this->lnIva=$pc;
		}

		function set_Total($pc)
		{
			$this->lnTotal=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc='')
		{
			$this->lcEstatus=($pc) ? $pc : '1';
		}

		function set_Porcentaje_Iva($pc='')
		{
			$this->lcPorcentajeIva=($pc) ? $pc : '1';
		}

		function consultar_facturas()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT *,TO_CHAR(fechafac, 'dd/mm/YYYY - HH12:MM AM') as fechafac, trim(porcentajeivafac) porcentajeivafac FROM tfactura,tchofer,taccesorio,tcliente,tvehiculo WHERE tchofer_idchofer=idchofer AND taccesorio_idaccesorio=idaccesorio AND tcliente_idcliente=idcliente AND tvehiculo_idvehiculo=idvehiculo;;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;					
				$Fila[$cont]['estatus_color']=($laRow['estatusfac'])?'success':'danger';
				$Fila[$cont]['estatusfac'] = ($laRow['estatusfac']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatusfac']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatusfac']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatusfac']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatusfac']) ? 'times' : 'refresh';					
				$cont++;
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_ultimas_facturas()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT *,TO_CHAR(fechafac, 'dd/mm/YYYY - HH12:MM AM') as fechafac, trim(porcentajeivafac) porcentajeivafac FROM tfactura,tchofer,taccesorio,tcliente,tvehiculo WHERE tchofer_idchofer=idchofer AND taccesorio_idaccesorio=idaccesorio AND tcliente_idcliente=idcliente AND tvehiculo_idvehiculo=idvehiculo ORDER BY tfactura.fechafac DESC LIMIT 5;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;					
				$Fila[$cont]['totalfac_lista']=number_format($laRow['totalfac'], 2, '.', ',');					
				$Fila[$cont]['estatus_color']=($laRow['estatusfac'])?'success':'danger';
				$Fila[$cont]['estatusfac'] = ($laRow['estatusfac']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatusfac']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatusfac']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatusfac']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatusfac']) ? 'times' : 'refresh';					
				$cont++;
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_factura()
		{
			$this->conectar();
			$sql="SELECT *,TO_CHAR(fechafac, 'dd-mm-YYYY - HH12:MM') as fechafac, trim(porcentajeivafac) porcentajeivafac,(SELECT descripcionmod FROM tmodelo,tvehiculo WHERE tvehiculo_idvehiculo=idvehiculo AND tmodelo_idmodelo=idmodelo) as modeloveh,(SELECT descripcionmod FROM tmodelo,taccesorio WHERE taccesorio_idaccesorio=idaccesorio AND tmodelo_idmodelo=idmodelo) as modeloacc,(SELECT descripcionmar FROM tmodelo,taccesorio,tmarca WHERE taccesorio_idaccesorio=idaccesorio AND tmodelo_idmodelo=idmodelo AND tmarca_idmarca=idmarca) as marcaacc,(SELECT descripcionmar FROM tmodelo,tvehiculo,tmarca WHERE tvehiculo_idvehiculo=idvehiculo AND tmodelo_idmodelo=idmodelo AND tmarca_idmarca=idmarca) as marcaveh FROM tfactura,tchofer,taccesorio,tcliente,tvehiculo WHERE idfactura='$this->lnIdFactura' AND tchofer_idchofer=idchofer AND taccesorio_idaccesorio=idaccesorio AND tcliente_idcliente=idcliente AND tvehiculo_idvehiculo=idvehiculo;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;			
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_productos_factura()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT *, (preciopro * cantidadpro) total_pro FROM tfactura_producto,tproducto WHERE tfactura_idfactura='$this->lnIdFactura' AND tproducto_idproducto=idproducto";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;
				$Fila[$cont]['nro']=($cont + 6);
				$Fila[$cont]['total_pro']=number_format($laRow['total_pro'], 2, '.', '');
				$cont++;			
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_precintos_factura()
		{
			$this->conectar();
			$sql="SELECT * FROM tprecinto WHERE tfactura_idfactura='$this->lnIdFactura'";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila['codigopre'].=$laRow['idcodigopre'].',';
			}
			$Fila['codigopre']=substr($Fila['codigopre'],0,strlen($Fila['codigopre'])-1);
			$this->desconectar();
			return $Fila;
		}

		function consultar_precintos_factura_b()
		{
			$cont=0;
			$this->conectar();
			$sql="SELECT * FROM tprecinto WHERE tfactura_idfactura='$this->lnIdFactura'";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;
				$cont++;
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_cliente()
		{
			$this->conectar();
			$sql="SELECT * FROM tcliente WHERE idcliente='$this->lnIdCliente';";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
			}
			$this->desconectar();
			return $Fila;
		}

		function registrar_factura()
		{
			$sql="INSERT INTO tfactura(
				            tvehiculo_idvehiculo, taccesorio_idaccesorio, tcliente_idcliente, 
				            tchofer_idchofer, ivafac, totalfac, observacionfac, estatusfac, fechafac, porcentajeivafac, prefijo_control, numero_control)
				    VALUES ('$this->lnVehiculo', '$this->lnAccesorio', '$this->lnCliente', 
				            '$this->lnChofer', '$this->lnIva', '$this->lnTotal', '$this->lcObservacion', '$this->lcEstatus', NOW(), '$this->lcPorcentajeIva', '00', (SELECT lpad(trim(to_char(numero, '99999999')) ,8,'0') FROM (SELECT count(*)+ 1 numero FROM tfactura) conteo));";
			$lnHecho=$this->ejecutar($sql);
			return $lnHecho;
		}

		function modificar_factura()
		{
			$sql="UPDATE tfactura
					   SET tvehiculo_idvehiculo='$this->lnVehiculo', taccesorio_idaccesorio='$this->lnAccesorio', 
					       tchofer_idchofer='$this->lnChofer', ivafac='$this->lnIva', totalfac='$this->lnTotal', 
					       observacionfac='$this->lcObservacion', estatusfac='$this->lcEstatus', porcentajeivafac = '$this->lcPorcentajeIva'
					 WHERE idfactura = '$this->lnIdFactura';";
			$lnHecho=$this->ejecutar($sql);
			return $lnHecho;
		}

		function registrar_detalle_factura($id_producto, $cantidad, $precio)
		{
			$sql="INSERT INTO tfactura_producto(
				            tfactura_idfactura, tproducto_idproducto, cantidadpro, preciopro)
				    VALUES ('$this->lnIdFactura', '$id_producto', '$cantidad', '$precio');";
			$lnHecho=$this->ejecutar($sql);
			return $lnHecho;
		}

		function limpiar_detalle_factura()
		{
			$sql="DELETE FROM tfactura_producto WHERE tfactura_idfactura='$this->lnIdFactura';";
			$lnHecho=$this->ejecutar($sql);
			return $lnHecho;
		}

		function eliminar_factura()
		{
			$this->conectar();
			$sql="UPDATE tfactura SET estatusfac='0' WHERE idfactura='$this->lnIdFactura';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_factura()
		{
			$this->conectar();
			$sql="UPDATE tfactura SET estatusfac='1' WHERE idfactura='$this->lnIdFactura';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function asignar_precinto($idprecinto)
		{
			$sql="UPDATE tprecinto
				   SET tfactura_idfactura='$this->lnIdFactura' ,
				       estatuspre='2'
				 WHERE idprecinto = '$idprecinto';";
			$lnHecho=$this->ejecutar($sql);	
			return $lnHecho;
		}

		function desasignar_precinto()
		{
			$sql="UPDATE tprecinto
				   SET tfactura_idfactura=NULL,
				       estatuspre='1'
				 WHERE tfactura_idfactura = '$this->lnIdFactura';";
			$lnHecho=$this->ejecutar($sql);	
			return $lnHecho;
		}

		function editar_factura()
		{
			$this->conectar();
			$sql="UPDATE tfactura
				   	 SET idcodigocli='$this->lcCodigoCliente', rifcli='$this->lcRif', razonsocial=UPPER('$this->lcNombre'), 
				         direccioncli=UPPER('$this->lcDireccion'), correounocli='$this->lcCorreouno', correodoscli='$this->lcCorreodos', correotrescli='$this->lcCorreotres', 
				         telefonounocli='$this->lnTelefonouno', telefonodoscli='$this->lnTelefonodos', telefonotrescli='$this->lnTelefonotres', observacioncli='$this->lcObservacion'
					WHERE idcliente='$this->lnIdCliente';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function venta_mensual()
		{
			$this->conectar();
			$sql="SELECT SUM(totalfac)as totalfac,(SELECT SUM(totalfac)as totalfac FROM tfactura WHERE EXTRACT(MONTH FROM fechafac)=EXTRACT(MONTH FROM NOW() - INTERVAL '1 months'))as mes_anterior_venta,(SELECT COUNT(*)as viaje FROM tfactura WHERE EXTRACT(MONTH FROM fechafac)=EXTRACT(MONTH FROM NOW() - INTERVAL '1 months'))as mes_anterior_viaje,(SELECT COUNT(*)as viaje FROM tfactura WHERE TO_CHAR(fechafac,'mm')=TO_CHAR(NOW(),'mm'))as viaje FROM tfactura WHERE TO_CHAR(fechafac,'mm')=TO_CHAR(NOW(),'mm');";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
				$Fila['totalfac']=($Fila['totalfac'])?$laRow['totalfac']:0;
				$Fila['viaje']=($Fila['viaje'])?$laRow['viaje']:0;
				$Fila['porcentaje_tendencia_venta']=($Fila['totalfac']!='0')?((($Fila['totalfac']-$Fila['mes_anterior_venta'])/$Fila['totalfac'])*100):0;

				$Fila['totalfac']=number_format($Fila['totalfac'],'2',',','.');
				$Fila['mes_anterior_venta']=number_format($Fila['mes_anterior_venta'],'2',',','.');
				$Fila['porcentaje_tendencia_venta']=number_format($Fila['porcentaje_tendencia_venta'],'2',',','.');
				$Fila['icono_tendencia_venta']=($Fila['totalfac']<$Fila['mes_anterior_venta'])?'up':'down';		
				$Fila['tendencia_venta']=($Fila['totalfac']<$Fila['mes_anterior_venta'])?'Mas':'Menos';

				
				$Fila['porcentaje_tendencia_viaje']=($Fila['viaje']!='0')?((($Fila['viaje']-$Fila['mes_anterior_viaje'])/$Fila['viaje'])*100):0;
				
				$Fila['icono_tendencia_viaje']=($Fila['viaje']>$Fila['mes_anterior_viaje'])?'up':'down';			
				$Fila['tendencia_viaje']=($Fila['viaje']>$Fila['mes_anterior_viaje'])?'Mas':'Menos';			
			}
			$this->desconectar();
			return $Fila;
		}

		function viaje_mensual()
		{
			$this->conectar();
			$sql="";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
								
			}
			$this->desconectar();
			return $Fila;
		}

		function obtener_nro_factura()
		{
			$this->conectar();
			$sql="SELECT last_value+1 nro_factura  from sidfactura;";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
			}
			$this->desconectar();
			return $Fila;
		}
	}
?>