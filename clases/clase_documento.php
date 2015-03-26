<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsDocumento extends clsModelo_pg
	{
		private $lcIdDocumento;
		private $lcIdChofer;
		private $lcDescripcion;
		private $lcVence;
		private $lcDuracion;
		private $lcObservacion;
		private $lcEstatus;

		function set_Documento($pc)
		{
			$this->lcIdDocumento=$pc;
		}

		function set_Chofer($pc)
		{
			$this->lcIdChofer=$pc;
		}

		function set_Descripcion($pc)
		{
			$this->lcDescripcion=$pc;
		}

		function set_Vence($pc)
		{
			$this->lcVence=$pc;
		}

		function set_Duracion($pc)
		{
			$this->lcDuracion=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
		{
			$this->lcEstatus=$pc;
		}

		function consultar_documentos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM tdocumento ORDER BY iddocumento ASC";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;					
					$Fila[$cont]['selected']=($laRow['iddocumento']==$this->lcIdDocumento)?'selected':'';
					$Fila[$cont]['duraciondoc']=($laRow['vencedoc'])?$laRow['duraciondoc'].' Año/s':'No vence';
					$Fila[$cont]['estatus_color']=($laRow['estatusdoc'])?'success':'danger';
					$Fila[$cont]['estatusdoc'] = ($laRow['estatusdoc']) ? 'Activo' : 'Inactivo';
					$Fila[$cont]['titulo'] = ($laRow['estatusdoc']) ? 'Desactivar' : 'Restaurar';
					$Fila[$cont]['color_boton'] = ($laRow['estatusdoc']) ? 'danger' : 'warning';
					$Fila[$cont]['funcion'] = ($laRow['estatusdoc']) ? 'eliminar' : 'restaurar';
					$Fila[$cont]['icono'] = ($laRow['estatusdoc']) ? 'times' : 'refresh';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}


		function consultar_documentos_chofer()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM tdocumento,tchofer,tchofer_documento WHERE idchofer='$this->lcIdChofer' AND idchofer=tchofer_idchofer AND iddocumento=tdocumento_iddocumento ORDER BY duraciondoc,fechaemisiondoc ASC";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					$Fila[$cont]['i']=$cont;
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_documento()
		{
			$this->conectar();
				$sql="SELECT * FROM tdocumento WHERE iddocumento='$this->lcIdDocumento'";
				$pcsql=$this->filtro($sql);
				
				if($laRow=$this->proximo($pcsql))
				{
					$Fila=$laRow;
					$Fila['checked_si']=($laRow['vencedoc'])?'checked':'';
					$Fila['checked_no']=(!$laRow['vencedoc'])?'checked':'';
					
				}
			
			$this->desconectar();
			return $Fila;
		}

		function registrar_documento()
		{
			$this->conectar();
			$sql="INSERT INTO tdocumento (descripciondoc,vencedoc,duraciondoc,observaciondoc,estatusdoc)VALUES('$this->lcDescripcion','$this->lcVence','$this->lcDuracion','$this->lcObservacion','1')";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_documento()
		{
			$this->conectar();
			$sql="UPDATE tdocumento SET estatusdoc='0' WHERE iddocumento='$this->lcIdDocumento' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_documento()
		{
			$this->conectar();
			$sql="UPDATE tdocumento SET estatusdoc='1' WHERE iddocumento='$this->lcIdDocumento' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_documento()
		{
			$this->conectar();
			$sql="UPDATE tdocumento SET descripciondoc='$this->lcDescripcion',vencedoc='$this->lcVence',duraciondoc='$this->lcDuracion',observaciondoc='$this->lcObservacion' WHERE iddocumento='$this->lcIdDocumento' ";
			echo $sql;
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>