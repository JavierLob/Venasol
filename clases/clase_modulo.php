<?php
	require_once('../nucleo/ModeloConectPg.php');
	class clsModulo extends clsModelo_pg
	{
		private $lcIdModulo;
		private $lcNombre;

		function set_Modulo($pcIdModulo)
		{
			$this->lcIdModulo=$pcIdModulo;
		}

		function set_Nombre($pcNombre)
		{
			$this->lcNombre=$pcNombre;
		}

		function consultar_modulos()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT idmodulo,nombremod,estatusmod FROM tmodulo ";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					$Fila[$cont]['estatusmod'] = ($laRow['estatusmod']) ? 'Activo' : 'Inactivo';
					$Fila[$cont]['titulo'] = ($laRow['estatusmod']) ? 'Desactivar' : 'Restaurar';
					$Fila[$cont]['color_boton'] = ($laRow['estatusmod']) ? 'danger' : 'warning';
					$Fila[$cont]['funcion'] = ($laRow['estatusmod']) ? 'eliminar' : 'restaurar';
					$Fila[$cont]['icono'] = ($laRow['estatusmod']) ? 'times' : 'refresh';
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_modulos_servicio($idmodulo_servicio)
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT idmodulo,nombremod,estatusmod FROM tmodulo ";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					$Fila[$cont]['selected'] = ($laRow['idmodulo']==$idmodulo_servicio)?'selected' : '';
					echo $Fila[$cont]['idmodulo'];
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_dependencia()
		{
			$this->conectar();
			$dependencia=false;			
				$sql="SELECT * FROM tmodulo_trol,tservicio WHERE tmodulo_trol.idmodulo='$this->lcIdModulo' OR tservicio.idmodulo='$this->lcIdModulo'";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$dependencia=true;
				}
			
			$this->desconectar();
			return $dependencia;
		}

		function consultar_modulo()
		{
			$this->conectar();
				$sql="SELECT idmodulo,nombremod FROM tmodulo WHERE idmodulo='$this->lcIdModulo'";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$Fila[0]=$laRow['idmodulo'];
					$Fila[1]=$laRow['nombremod'];
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_modulo_bitacora()
		{
			$this->conectar();
				$sql="SELECT nombremod FROM tmodulo WHERE idmodulo='$this->lcIdModulo'";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					foreach ($laRow as $key => $value)
					{
						$Fila[$key]=$value;
					}
				}
			$this->desconectar();
			return $Fila;
		}

		function registrar_modulo()
		{
			$this->conectar();
			$sql="INSERT INTO tmodulo (nombremod)VALUES('$this->lcNombre')";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_modulo()
		{
			$this->conectar();
			$sql="UPDATE tmodulo SET estatusmod='0' WHERE idmodulo='$this->lcIdModulo' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_modulo()
		{
			$this->conectar();
			$sql="UPDATE tmodulo SET estatusmod='1' WHERE idmodulo='$this->lcIdModulo' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_modulo()
		{
			$this->conectar();
			$sql="UPDATE tmodulo SET nombremod='$this->lcNombre' WHERE idmodulo='$this->lcIdModulo' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>