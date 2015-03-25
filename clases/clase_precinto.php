<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsPrecinto extends clsModelo_pg
	{
		private $lnIdPrecinto;
		private $lcIdCodigo;
		private $lnIdFactura;
		private $lcObservacion;
		private $lcEstatus;

		function set_Precinto($pc)
		{
			$this->lnIdPrecinto=$pc;
		}

		function set_Codigo($pc)
		{
			$this->lcIdCodigo=$pc;
		}


		function set_Factura($pc)
		{
			$this->lnIdFactura=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
		{
			$this->lcEstatus=$pc;
		}


		function consultar_precintos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM tprecinto";
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

		function consultar_precinto()
		{
			$this->conectar();
				$sql="SELECT idprecinto,idcodigopre, observacionpre FROM tprecinto WHERE idprecinto='$this->lnIdPrecinto' ";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$Fila=$laRow;									
				}
			
			$this->desconectar();
			return $Fila;
		}

		function registrar_precinto()
		{
			$this->conectar();
			$sql="INSERT INTO tprecinto (idcodigopre, tfactura_idfactura,observacionpre, estatuspre)VALUES('$this->lcIdCodigo','$this->lnIdFactura','$this->lcObservacion','1')";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_precinto()
		{
			$this->conectar();
			$sql="UPDATE tprecinto SET estatuspro='0' WHERE idprecinto='$this->lnIdPrecinto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_precinto()
		{
			$this->conectar();
			$sql="UPDATE tprecinto SET estatuspro='1' WHERE idprecinto='$this->lnIdPrecinto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_precinto()
		{
			$this->conectar();
			$sql="UPDATE tprecinto SET idcodigopro='$this->lcIdCodigo',tfactura_idfactura='$this->lnIdFactura',observacionpre='$this->lcObservacion' WHERE idprecinto='$this->lnIdPrecinto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>