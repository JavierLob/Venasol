<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsServicio extends clsModelo_pg
	{
		private $lcIdServicio;
		private $lcNombre;
		private $lcEnlace;
		private $lcVisible;
		private $lcModulo;

		function set_Servicio($pcIdServicio)
		{
			$this->lcIdServicio=$pcIdServicio;
		}

		function set_Nombre($pcNombre)
		{
			$this->lcNombre=$pcNombre;
		}

		function set_Enlace($pcEnlace)
		{
			$this->lcEnlace=$pcEnlace;
		}

		function set_Visible($pcVisible)
		{
			$this->lcVisible=$pcVisible;
		}

		function set_Modulo($pcModulo)
		{
			$this->lcModulo=$pcModulo;
		}

		function consultar_servicios()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT idservicio,nombreser,enlaceser,visibleser,nombremod,estatusser FROM tservicio,tmodulo WHERE tservicio.idmodulo=tmodulo.idmodulo ORDER BY idservicio ASC";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;					
					$Fila[$cont]['visibleser']=($laRow['visibleser'])?'Si':'No';
					$Fila[$cont]['estatus_color']=($laRow['estatusser'])?'success':'danger';
					$Fila[$cont]['estatusser'] = ($laRow['estatusser']) ? 'Activo' : 'Inactivo';
					$Fila[$cont]['titulo'] = ($laRow['estatusser']) ? 'Desactivar' : 'Restaurar';
					$Fila[$cont]['color_boton'] = ($laRow['estatusser']) ? 'danger' : 'warning';
					$Fila[$cont]['funcion'] = ($laRow['estatusser']) ? 'eliminar' : 'restaurar';
					$Fila[$cont]['icono'] = ($laRow['estatusser']) ? 'times' : 'refresh';					
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_dependencia()
		{
			$this->conectar();
			$dependencia=false;			
				$sql="SELECT * FROM tservicio_trol WHERE idservicio='$this->lcIdServicio' ";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$dependencia=true;
				}
			
			$this->desconectar();
			return $dependencia;
		}

		function consultar_servicios_modulo($idmodulo)
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT idservicio,nombreser,enlaceser,visibleser,nombremod FROM tservicio,tmodulo WHERE tservicio.idmodulo='$idmodulo' AND tservicio.idmodulo=tmodulo.idmodulo AND estatusser='1' ORDER BY visibleser DESC";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont][0]=$laRow['idservicio'];
					$Fila[$cont][1]=$laRow['nombreser'];
					$Fila[$cont][2]=$laRow['enlaceser'];
					$Fila[$cont][3]=$laRow['nombremod'];
					$Fila[$cont][4]=$laRow['visibleser'];
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_servicio()
		{
			$this->conectar();
				$sql="SELECT idservicio,nombreser,enlaceser,visibleser,idmodulo FROM tservicio WHERE idservicio='$this->lcIdServicio'";
				$pcsql=$this->filtro($sql);
				
				if($laRow=$this->proximo($pcsql))
				{
					$Fila=$laRow;
					$Fila['checked_si']=($laRow['visibleser'])?'checked':'';
					$Fila['checked_no']=(!$laRow['visibleser'])?'checked':'';
					$Fila['checked_si']=($laRow['visibleser'])?'active':'';
					$Fila['checked_no']=(!$laRow['visibleser'])?'active':'';
					
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_servicio_bitacora()
		{
			$this->conectar();
				$sql="SELECT nombreser,enlaceser,visibleser,idmodulo FROM tservicio WHERE idservicio='$this->lcIdServicio'";
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

		function registrar_servicio()
		{
			$this->conectar();
			$sql="INSERT INTO tservicio (nombreser,enlaceser,visibleser,idmodulo)VALUES('$this->lcNombre','$this->lcEnlace','$this->lcVisible','$this->lcModulo')";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_servicio()
		{
			$this->conectar();
			$sql="UPDATE tservicio SET estatusser='0' WHERE idservicio='$this->lcIdServicio' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_servicio()
		{
			$this->conectar();
			$sql="UPDATE tservicio SET estatusser='1' WHERE idservicio='$this->lcIdServicio' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_servicio()
		{
			$this->conectar();
			$sql="UPDATE tservicio SET nombreser='$this->lcNombre',enlaceser='$this->lcEnlace',visibleser='$this->lcVisible',idmodulo='$this->lcModulo' WHERE idservicio='$this->lcIdServicio' ";
			echo $sql;
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}
	}
?>