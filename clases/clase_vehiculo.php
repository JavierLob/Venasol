<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsVehiculo extends clsModelo_pg
	{
		private $lnIdVehiculo;
		private $lcCodigo;
		private $lcAlias;
		private $lcPlaca;
		private $lcAno;
		private $lcColor;
		private $lnModelo;
		private $lcObservacion;
		private $lcEstatus;

		function set_Vehiculo($pc)
		{
			$this->lnIdVehiculo=$pc;
		}

		function set_Codigo($pc)
		{
			$this->lcCodigo=$pc;
		}

		function set_Alias($pc)
		{
			$this->lcAlias=$pc;
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


		function consultar_vehiculos()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT tvehiculo.*, tmodelo.descripcionmod, tmarca.descripcionmar
					FROM tvehiculo, tmodelo, tmarca
					WHERE tmodelo.idmodelo = tmodelo_idmodelo
					AND tmarca.idmarca = tmarca_idmarca;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;					
				$Fila[$cont]['estatus_color']=($laRow['estatusveh'])?'success':'danger';
				$Fila[$cont]['estatusveh'] = ($laRow['estatusveh']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatusveh']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatusveh']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatusveh']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatusveh']) ? 'times' : 'refresh';					
				$cont++;
			}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_vehiculo()
		{
			$this->conectar();
			$sql="SELECT tvehiculo.*, tmodelo.descripcionmod, tmarca.descripcionmar, tmarca.idmarca
					FROM tvehiculo, tmodelo, tmarca
					WHERE tvehiculo.idvehiculo = '$this->lnIdVehiculo' 
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

		function registrar_vehiculo()
		{
			$this->conectar();
				$sql="INSERT INTO tvehiculo(
					            idcodigoveh, aliasveh, placaveh, anoveh, colorveh, 
					            tmodelo_idmodelo, observacionveh, estatusveh)
					    VALUES ('$this->lcCodigo', UPPER('$this->lcAlias'), upper('$this->lcPlaca'), '$this->lcAno', '$this->lcColor', '$this->lnModelo', 
					            '$this->lcObservacion', '$this->lcEstatus');";
				$lnHecho=$this->ejecutar($sql);

			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_vehiculo()
		{
			$this->conectar();
			$sql="UPDATE tvehiculo SET estatusveh='0' WHERE idvehiculo='$this->lnIdVehiculo';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_vehiculo()
		{
			$this->conectar();
			$sql="UPDATE tvehiculo SET estatusveh='1' WHERE idvehiculo='$this->lnIdVehiculo';";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_vehiculo()
		{
			$this->conectar();
			$sql="UPDATE tvehiculo
				   SET idcodigoveh='$this->lcCodigo', aliasveh=upper('$this->lcAlias'), placaveh=upper('$this->lcPlaca'), anoveh='$this->lcAno', 
				       colorveh='$this->lcColor', tmodelo_idmodelo='$this->lnModelo', observacionveh='$this->lcObservacion'
				 WHERE idvehiculo = '$this->lnIdVehiculo';";
			echo $sql;
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>