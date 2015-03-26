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
		private $lcFechaNacimiento;
		private $lcDireccion;
		private $lcCorreo;
		private $lcTelefonoMovil;
		private $lcTelefonoLocal;
		private $lcObservacion;
		private $lcEstatus;

		private $lnIdDocumento;
		private $ldFechaEmision;
		private $ldFechaVencimiento;
		private $lcDirectorio;


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


		function set_FechaNacimiento($pc)
		{
			$this->lcFechaNacimiento=$this->fecha_bd($pc);
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


		function consultar_choferes()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM tchofer";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;					
					$Fila[$cont]['estatus_color']=($laRow['estatuscho'])?'success':'danger';
					$Fila[$cont]['estatuscho'] = ($laRow['estatuscho']) ? 'Activo' : 'Inactivo';
					$Fila[$cont]['titulo'] = ($laRow['estatuscho']) ? 'Desactivar' : 'Restaurar';
					$Fila[$cont]['color_boton'] = ($laRow['estatuscho']) ? 'danger' : 'warning';
					$Fila[$cont]['funcion'] = ($laRow['estatuscho']) ? 'eliminar' : 'restaurar';
					$Fila[$cont]['icono'] = ($laRow['estatuscho']) ? 'times' : 'refresh';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_chofer()
		{
			$this->conectar();
				$sql="SELECT *,RTRIM(idcodigocho,' ')as idcodigocho FROM tchofer WHERE idchofer='$this->lnIdChofer' ";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$Fila=$laRow;
					$Fila['inicial_rif']=substr($Fila['cedula_rifcho'],0,1);
					$Fila['cedula_rif']=substr($Fila['cedula_rifcho'],1,strlen($Fila['cedula_rifcho']));
				}
			
			$this->desconectar();
			return $Fila;
		}

		function registrar_chofer()
		{
			$this->conectar();
			$this->begin();
				$sql="INSERT INTO tchofer (idcodigocho, aliascho, nombrecho, apellidocho, cedula_rifcho, 
            fechanacimientocho, direccioncho, correocho, 
            telefonomovilcho, telefonolocalcho, observacioncho, estatuscho)VALUES(UPPER('$this->lcIdCodigo'),UPPER('$this->lcAlias'),UPPER('$this->lcNombre'),UPPER('$this->lcApellido'),'$this->lnCedulaRif','$this->lcFechaNacimiento',UPPER('$this->lcDireccion'),UPPER('$this->lcCorreo'),UPPER('$this->lcTelefonoMovil'),UPPER('$this->lcTelefonoLocal'),UPPER('$this->lcObservacion'),'1')";
				if($lnHecho=$this->ejecutar($sql))
				{
					for($i=0;$i<count($this->lnIdDocumento);$i++)
					{
						$sql="INSERT INTO tchofer_documento(tchofer_idchofer, tdocumento_iddocumento, fechaemisiondoc, fechavencimientodoc, directoriodoc, estatusdoc)VALUES ((SELECT idchofer FROM tchofer WHERE cedula_rifcho='$this->lnCedulaRif'),".$this->lnIdDocumento[$i].", '".$this->fecha_bd($this->ldFechaEmision[$i])."', '".$this->fecha_bd($this->ldFechaVencimiento[$i])."', '".$this->lcDirectorio[$i]."', '1')";
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
			$this->begin();
			$sql="UPDATE tchofer SET idcodigocho=UPPER('$this->lcIdCodigo'),aliascho	=UPPER('$this->lcAlias'),nombrecho=UPPER('$this->lcNombre'),apellidocho=UPPER('$this->lcApellido'),cedula_rifcho='$this->lnCedulaRif',fechanacimientocho='$this->lcFechaNacimiento',direccioncho=UPPER('$this->lcDireccion'),correocho=UPPER('$this->lcCorreo'),telefonomovilcho='$this->lcTelefonoMovil',telefonolocalcho='$this->lcTelefonoLocal',observacioncho=UPPER('$this->lcObservacion') WHERE idchofer='$this->lnIdChofer' ";
			if($lnHecho=$this->ejecutar($sql))
			{
				for($i=0;$i<count($this->lnIdDocumento);$i++)
				{
					$sql="UPDATE tchofer_documento SET fechaemisiondoc='$this->fecha_bd(".$this->ldFechaEmision[$i].")',fechavencimientodoc='$this->fecha_bd(".$this->ldFechaVencimiento[$i].")' WHERE tchofer_idchofer='$this->lnIdChofer' AND tdocumento_iddocumento='".$this->lnIdDocumento[$i]."'";
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
	}
?>