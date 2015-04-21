<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsConfiguracion extends clsModelo_pg
	{
		private $lcImagenLogo;
		private $lcImagenReporte;
		private $lcImagenLogo_Oscuro;
		private $lcImagenShort_Icon;

		function set_ImagenLogo($pc)
		{
			$this->lcImagenLogo=$pc;
		}

		function set_ImagenReporte($pc)
		{
			$this->lcImagenReporte=$pc;
		}
		
		function set_ImagenLogo_Oscuro($pc)
		{
			$this->lcImagenLogo_Oscuro=$pc;
		}

		function set_ImagenShort_Icon($pc)
		{
			$this->lcImagenShort_Icon=$pc;
		}
		function consultar_configuracion()
		{
			$this->conectar();
			$sql="SELECT * FROM tconfiguracion";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$fila=$laRow;
			}
			$this->desconectar;
			return $fila;
		}

		
		function guardar_configuracion()
		{
			$this->conectar();
			$sql="UPDATE tconfiguracion SET imagenlogo='$this->lcImagenLogo',imagenreporte='$this->lcImagenReporte',imagenlogo_oscuro='$this->lcImagenLogo_Oscuro',imagenshort_icon='$this->lcImagenShort_Icon' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>