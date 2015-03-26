<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsAccesorio extends clsModelo_pg
	{
		private $lnIdAccesorio;
		private $lcCodigo;
		private $lcCapacidad;
		private $lcPlaca;
		private $lcAno;
		private $lcColor;
		private $lnModelo;
		private $lcObservacion;
		private $lcUnidadMedida;
		private $lcEstatus;

		function set_Accesorio($pc)
		{
			$this->lnIdAccesorio=$pc;
		}

		function set_Codigo($pc)
		{
			$this->lcCodigo=$pc;
		}

		function set_UnidadMedida($pc)
		{
			$this->lcUnidadMedida=$pc;
		}

		function set_Capacidad($pc)
		{
			$this->lcCapacidad=$pc;
		}

		function set_Placa($pc)
		{
			$this->lcPlaca=$pc;
		}

		function set_Ano($pc)
		{
			$this->lcAno=$pc;
		}

		function set_Color($pc)
		{
			$this->lcColor=$pc;
		}

		function set_Modelo($pc)
		{
			$this->lnModelo=$pc;
		}

		function set_Observacion($pc)
		{
			$this->lcObservacion=$pc;
		}

		function set_Estatus($pc)
		{
			$this->lcEstatus=($pc) ? $pc : '1';
		}


		function consultar_accesorios()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT taccesorio.*, tmodelo.descripcionmod, tmarca.descripcionmar
					FROM taccesorio, tmodelo, tmarca
					WHERE tmodelo.idmodelo = tmodelo_idmodelo
					AND tmarca.idmarca = tmarca_idmarca;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;					
				$Fila[$cont]['estatus_color']=($laRow['estatusacc'])?'success':'danger';
				$Fila[$cont]['estatusacc'] = ($laRow['estatusacc']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatusacc']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatusacc']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatusacc']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatusacc']) ? 'times' : 'refresh';					
				$cont++;
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_accesorio()
		{
			$this->conectar();
			$sql="SELECT taccesorio.*, tmodelo.descripcionmod, tmarca.descripcionmar, tmarca.idmarca
					FROM taccesorio, tmodelo, tmarca
					WHERE taccesorio.idaccesorio = '$this->lnIdAccesorio' 
					AND tmodelo.idmodelo = tmodelo_idmodelo
					AND tmarca.idmarca = tmarca_idmarca;";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
			}
			$this->desconectar();
			return $Fila;
		}

		function registrar_accesorio()
		{
			$this->conectar();
				$sql="INSERT INTO taccesorio(
					            idcodigoacc, capacidadacc,unidadmedidaacc, placaacc, anoacc, coloracc, 
					            tmodelo_idmodelo, observacionacc, estatusacc)
					    VALUES ('$this->lcCodigo', '$this->lcCapacidad','$this->lcUnidadMedida', '$this->lcPlaca', '$this->lcAno', '$this->lcColor', '$this->lnModelo', 
					            '$this->lcObservacion', '$this->lcEstatus');";
				$lnHecho=$this->ejecutar($sql);

			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_accesorio()
		{
			$this->conectar();
			$sql="UPDATE taccesorio SET estatusacc='0' WHERE idaccesorio='$this->lnIdAccesorio';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_accesorio()
		{
			$this->conectar();
			$sql="UPDATE taccesorio SET estatusacc='1' WHERE idaccesorio='$this->lnIdAccesorio';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_accesorio()
		{
			$this->conectar();
			$sql="UPDATE taccesorio
				   SET idcodigoacc='$this->lcCodigo', capacidadacc='$this->lcCapacidad', unidadmedidaacc='$this->lcUnidadMedida', placaacc='$this->lcPlaca', anoacc='$this->lcAno', 
				       coloracc='$this->lcColor', tmodelo_idmodelo='$this->lnModelo', observacionacc='$this->lcObservacion'
				 WHERE idaccesorio = '$this->lnIdAccesorio';";
			echo $sql;
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>