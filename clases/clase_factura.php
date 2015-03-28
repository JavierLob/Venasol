<?php
	/*
	idfactura bigint NOT NULL DEFAULT nextval('sidfactura'::regclass),
  tvehiculo_idvehiculo bigint NOT NULL,
  taccesorio_idaccesorio bigint NOT NULL,
  tcliente_idcliente bigint NOT NULL,
  tchofer_idchofer bigint NOT NULL,
  ivafac numeric(10,2) NOT NULL,
  totalfac numeric(10,2) NOT NULL,
  observacionfac character varying(255),
  estatusfac character(1) NOT NULL,*/
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


		function consultar_clientes()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT * FROM tcliente;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;					
				$Fila[$cont]['estatus_color']=($laRow['estatuscli'])?'success':'danger';
				$Fila[$cont]['estatuscli'] = ($laRow['estatuscli']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatuscli']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatuscli']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatuscli']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatuscli']) ? 'times' : 'refresh';					
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

		function eliminar_cliente()
		{
			$this->conectar();
			$sql="UPDATE tcliente SET estatuscli='0' WHERE idcliente='$this->lnIdCliente';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_cliente()
		{
			$this->conectar();
			$sql="UPDATE tcliente SET estatuscli='1' WHERE idcliente='$this->lnIdCliente';";
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


		function editar_cliente()
		{
			$this->conectar();
			$sql="UPDATE tcliente
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