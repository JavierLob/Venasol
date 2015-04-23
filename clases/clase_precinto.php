<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsPrecinto extends clsModelo_pg
	{
		private $lnIdPrecinto;
		private $lcIdCodigo;
		private $lnIdFactura;
		private $lcObservacion;
		private $lcEstatus;
		private $lcGrupo;

		function set_Precinto($pc)
		{
			$this->lnIdPrecinto=$pc;
		}

		function set_Codigo($pc)
		{
			$this->lcIdCodigo=$pc;
		}

		function set_Grupo($pc)
		{
			$this->lcGrupo=$pc;
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
				$sql="SELECT *,(SELECT numero_control FROM tfactura WHERE tfactura_idfactura=idfactura)as numero_control FROM tprecinto";
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
					$Fila[$cont]['numero_control'] = ($laRow['numero_control']) ? $laRow['numero_control'] : 'Sin usar';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_precinto()
		{
			$this->conectar();
				$sql="SELECT idprecinto,idcodigopre, observacionpre,tfactura_idfactura,(SELECT numero_control FROM tfactura WHERE tfactura_idfactura=idfactura)as numero_control FROM tprecinto WHERE idprecinto='$this->lnIdPrecinto' ";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$Fila=$laRow;
					$Fila['tfactura_idfactura'] = ($laRow['tfactura_idfactura']) ? $laRow['tfactura_idfactura'] : 'Sin usar';					

				}
			
			$this->desconectar();
			return $Fila;
		}

		function validar_repetido()
		{
			$this->conectar();
			$lnHecho=false;
				$sql="SELECT idprecinto,idcodigopre,observacionpre FROM tprecinto WHERE idcodigopre='$this->lcIdCodigo' ";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$lnHecho=true;

				}
			
			$this->desconectar();
			return $lnHecho;
		}

		function registrar_precinto()
		{
			$this->conectar();
			$this->begin();
			$grupo=1;
			$idgrupo=$this->lcIdCodigo[0];
			for($i=0;$i<count($this->lcIdCodigo);$i++) 
			{
				$idgrupo=($grupo==$this->lcGrupo[$i])?$idgrupo:$this->lcIdCodigo[$i];
				$grupo=($grupo==$this->lcGrupo[$i])?$grupo:$this->lcGrupo[$i];
				$sql="INSERT INTO tprecinto (idcodigopre,observacionpre, estatuspre,grupopre)VALUES('".$this->lcIdCodigo[$i]."','".$this->lcObservacion[$i]."','1','$idgrupo')";
				if(!$lnHecho=$this->ejecutar($sql))
				{
					$this->rollback();
					break;
				}
			}
			if($lnHecho)
				$this->commit();

			return $lnHecho;
		}

		function registrar_precinto_ajax()
		{
			$this->conectar();

			$sql="INSERT INTO tprecinto (idcodigopre,observacionpre, estatuspre,grupopre)VALUES('$this->lcIdCodigo','$this->lcObservacion','1','$this->lcIdCodigo')";
			$lnHecho=$this->ejecutar($sql);

			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_precinto()
		{
			$this->conectar();
			$sql="UPDATE tprecinto SET estatuspre='0' WHERE idprecinto='$this->lnIdPrecinto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_precinto()
		{
			$this->conectar();
			$sql="UPDATE tprecinto SET estatuspre='1' WHERE idprecinto='$this->lnIdPrecinto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_precinto()
		{
			$this->conectar();
			$sql="UPDATE tprecinto SET idcodigopre='$this->lcIdCodigo',grupopre='$this->lcGrupo',observacionpre='$this->lcObservacion' WHERE idprecinto='$this->lnIdPrecinto' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function consultar_grupo_precintos_activos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT grupopre FROM tprecinto WHERE estatuspre='1' GROUP BY grupopre";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					$Fila[$cont]["i"]=$cont;
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_grupo_precintos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT idprecinto,idcodigopre,grupopre FROM tprecinto WHERE grupopre='$this->lcGrupo' ORDER BY idcodigopre";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_precintos_activos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM tprecinto WHERE estatuspre='1'";
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
					$Fila[$cont]['tfactura_idfactura'] = ($laRow['tfactura_idfactura']) ? $laRow['tfactura_idfactura'] : 'Sin usar';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}
	}
?>