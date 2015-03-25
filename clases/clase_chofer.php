<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsChofer extends clsModelo_pg
	{
		private $lnIdChofer;
		private $lcIdCodigo;
		private $lcAlias;
		private $lcNombre;
		private $lcApellido;
		private $lnCedulaRif;
		private $lcNacionalidad;
		private $lcFechaNacimiento;
		private $lcDireccion;
		private $lcCorreo;
		private $lcTelefonoMovil;
		private $lcTelefonoLocal;
		private $lcObservacion;
		private $lcEstatus;

		function set_Chofer($pc)
		{
			$this->lnIdChofer=$pc;
		}

		function set_Codigo($pc)
		{
			$this->lcIdCodigo=$pc;
		}

		function set_Alias($pc)
		{
			$this->lcAlias=$pc;
		}

		function set_Nombre($pc)
		{
			$this->lcNombre=$pc;
		}

		function set_Apellido($pc)
		{
			$this->lcApellido=$pc;
		}

		function set_CedulaRif($pc)
		{
			$this->lnCedulaRif=$pc;
		}

		function set_Nacionalidad($pc)
		{
			$this->lcNacionalidad=$pc;
		}

		function set_FechaNacimiento($pc)
		{
			$this->lcFechaNacimiento=$pc;
		}

		function set_Direccion($pc)
		{
			$this->lcDireccion=$pc;
		}

		function set_Correo($pc)
		{
			$this->lcCorreo=$pc;
		}

		function set_TelefonoMovil($pc)
		{
			$this->lcTelefonoMovil=$pc;
		}

		function set_TelefonoLocal($pc)
		{
			$this->lcTelefonoLocal=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
		{
			$this->lcEstatus=$pc;
		}


		function consultar_choferes()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM tchofer";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;					
					$Fila[$cont]['estatus_color']=($laRow['estatuspre'])?'success':'danger';
					$Fila[$cont]['estatuspre'] = ($laRow['estatuspre']) ? 'Activo' : 'Inactivo';
					$Fila[$cont]['titulo'] = ($laRow['estatuspre']) ? 'Desactivar' : 'Restaurar';
					$Fila[$cont]['color_boton'] = ($laRow['estatuspre']) ? 'danger' : 'warning';
					$Fila[$cont]['funcion'] = ($laRow['estatuspre']) ? 'eliminar' : 'restaurar';
					$Fila[$cont]['icono'] = ($laRow['estatuspre']) ? 'times' : 'refresh';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_chofer()
		{
			$this->conectar();
				$sql="SELECT idchofer,idcodigopro, observacionpre FROM tchofer WHERE idchofer='$this->lnIdChofer' ";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$Fila=$laRow;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function registrar_chofer()
		{
			$this->conectar();
				$sql="INSERT INTO tchofer (idcodigocho, aliascho, nombrecho, apellidocho, ceula_rifcho, 
            nacionalidadcho, fechanacimientocho, direccioncho, correocho, 
            telefonomovilcho, telefonolocalcho, observacioncho, estatuscho)VALUES('$this->lcIdCodigo','$this->lcAlias','$this->lcNombre','$this->lcApellido','$this->lnCedulaRif','$this->lcNacionalidad','$this->lcFechaNacimiento','$this->lcDireccion','$this->lcCorreo','$this->lcTelefonoMovil','$this->lcTelefonoLocal','$this->lcObservacion','1')";
				$lnHecho=$this->ejecutar($sql);

			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_chofer()
		{
			$this->conectar();
			$sql="UPDATE tchofer SET estatuscho='0' WHERE idchofer='$this->lnIdChofer' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_chofer()
		{
			$this->conectar();
			$sql="UPDATE tchofer SET estatuscho='1' WHERE idchofer='$this->lnIdChofer' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_chofer()
		{
			$this->conectar();
			$sql="UPDATE tchofer SET idcodigocho='$this->lcIdCodigo',aliaspro='$this->lcAlias',nombrecho='$this->lcNombre',apellidocho='$this->lcApellido',ceula_rifcho='$this->lnCedulaRif',nacionalidadcho='$this->lcNacionalidad',fechanacimientocho='$this->lcFechaNacimiento',direccioncho='$this->lcDireccion',correocho='$this->lcCorreo',telefonomovilcho='$this->lcTelefonoMovil',telefonolocalcho='$this->lcTelefonoLocal',observacioncho='$this->lcObservacion' WHERE idchofer='$this->lnIdChofer' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>