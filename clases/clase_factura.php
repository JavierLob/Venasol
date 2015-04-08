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


		function consultar_facturas()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT * FROM tfactura,tchofer,taccesorio,tcliente,tvehiculo WHERE tchofer_idchofer=idchofer AND taccesorio_idaccesorio=idaccesorio AND tcliente_idcliente=idcliente AND tvehiculo_idvehiculo=idvehiculo;;";
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

		function consultar_factura()
		{
			$this->conectar();
			$sql="SELECT *,TO_CHAR(fechafac, 'dd-mm-YYYY - HH12:MM') as fechafac,(SELECT descripcionmod FROM tmodelo,tvehiculo WHERE tvehiculo_idvehiculo=idvehiculo AND tmodelo_idmodelo=idmodelo) as modeloveh,(SELECT descripcionmod FROM tmodelo,taccesorio WHERE taccesorio_idaccesorio=idaccesorio AND tmodelo_idmodelo=idmodelo) as modeloacc,(SELECT descripcionmar FROM tmodelo,taccesorio,tmarca WHERE taccesorio_idaccesorio=idaccesorio AND tmodelo_idmodelo=idmodelo AND tmarca_idmarca=idmarca) as marcaacc,(SELECT descripcionmar FROM tmodelo,tvehiculo,tmarca WHERE tvehiculo_idvehiculo=idvehiculo AND tmodelo_idmodelo=idmodelo AND tmarca_idmarca=idmarca) as marcaveh FROM tfactura,tchofer,taccesorio,tcliente,tvehiculo WHERE idfactura='$this->lnIdFactura' AND tchofer_idchofer=idchofer AND taccesorio_idaccesorio=idaccesorio AND tcliente_idcliente=idcliente AND tvehiculo_idvehiculo=idvehiculo;";
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
				            tchofer_idchofer, ivafac, totalfac, observacionfac, estatusfac, fechafac)
				    VALUES ('$this->lnVehiculo', '$this->lnAccesorio', '$this->lnCliente', 
				            '$this->lnChofer', '$this->lnIva', '$this->lnTotal', '$this->lcObservacion', '$this->lcEstatus', NOW());";
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