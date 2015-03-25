<?php
	require_once('../nucleo/ModeloConectPg.php');
	class clsCliente extends clsModelo_pg
	{
		private $lnIdCliente;
		private $lcCodigoCliente;
		private $lcRif;
		private $lcNombre;
		private $lcApellido;
		private $lcDireccion;
		private $lcCorreouno;
		private $lcCorreodos;
		private $lcCorreotres;
		private $lnTelefonouno;
		private $lnTelefonodos;
		private $lnTelefonotres;
		private $lcObservacion;
		private $lcEstatus;

		function set_Cliente($pc)
		{
			$this->lnIdCliente=$pc;
		}

		function set_Codigo($pc)
		{
			$this->lcCodigoCliente=$pc;
		}

		function set_Rif($pc)
		{
			$this->lcRif=$pc;
		}

		function set_Nombre($pc)
		{
			$this->lcNombre=$pc;
		}

		function set_Apellido($pc)
		{
			$this->lcApellido=$pc;
		}

		function set_Direccion($pc)
		{
			$this->lcDireccion=$pc;
		}

		function set_Correo($pc, $pcd='', $pct='')
		{
			$this->lcCorreouno=$pc;
			$this->lcCorreodos=trim($pcd);
			$this->lcCorreotres=trim($pct);
		}

		function set_Telefono($pc='', $pcd='', $pct='')
		{
			$this->lnTelefonouno=$pc;
			$this->lnTelefonodos=trim($pcd);
			$this->lnTelefonotres=trim($pct);
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
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

		function registrar_cliente()
		{
			$this->conectar();
				$sql="INSERT INTO tcliente(
					            	idcodigocli, rifcli, razonsocial, direccioncli, 
						            correounocli, correodoscli, correotrescli, telefonounocli, telefonodoscli, 
						            telefonotrescli, observacioncli, estatuscli)
						    VALUES ('$this->lcCodigoCliente', '$this->lcRif', UPPER('$this->lcNombre'), UPPER('$this->lcDireccion'), 
						            '$this->lcCorreouno', '$this->lcCorreodos', '$this->lcCorreotres', '$this->lnTelefonouno', '$this->lnTelefonodos', 
						            '$this->lnTelefonotres', '$this->lcObservacion', '$this->lcEstatus');";
				$lnHecho=$this->ejecutar($sql);

			$this->desconectar();
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

		function editar_cliente()
		{
			$this->conectar();
			$sql="UPDATE tcliente
				   	 SET idcodigocli='$this->lcCodigoCliente', rifcli='$this->lcRif', razonsocial=UPPER('$this->lcNombre'), 
				         direccioncli=UPPER('$this->lcDireccion'), correounocli='$this->lcCorreouno', correodoscli='$this->lcCorreodos', correotrescli='$this->lcCorreotres', 
				         telefonounocli='$this->lnTelefonouno', telefonodoscli='$this->lnTelefonodos', telefonotrescli='$this->lnTelefonotres', observacioncli='$this->lcObservacion'
					WHERE idcliente='$this->lnIdCliente';";
			echo $sql;
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>