<?php

	require_once('../nucleo/ModeloConectPg.php');
	class clsRol extends clsModelo_pg
	{
		private $lcIdRol;
		private $lcNombre;
		private $lcModulo;
		private $lcOrden;
		private $lcServicio;

		function set_Rol($pcIdRol)
		{
			$this->lcIdRol=$pcIdRol;
		}

		function set_Nombre($pcNombre)
		{
			$this->lcNombre=$pcNombre;
		}

		function set_Modulo($pcModulo)
		{
			$this->lcModulo=$pcModulo;
		}

			function set_Orden($pcOrden)
		{
			$this->lcOrden=$pcOrden;
		}

		function set_Servicio($pcServicio)
		{
			$this->lcServicio=$pcServicio;
		}

		function consultar_roles()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT * FROM trol ";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont] = $laRow;
				$Fila[$cont]['estatusrol'] = ($laRow['estatusrol']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatusrol']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatusrol']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatusrol']) ? 'desactivar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatusrol']) ? 'times' : 'refresh';
				$Fila[$cont]['active'] = ($cont==0) ? 'active' : '';
				$Fila[$cont]['i'] = $cont;
				$cont++;
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_dependencia()
		{
			$this->conectar();
			$dependencia=false;			
				$sql="SELECT * FROM tusuario,tmodulo_trol,tservicio_trol WHERE tusuario.trol_idrol='$this->lcIdRol' OR tmodulo_trol.idrol='$this->lcIdRol' OR tservicio_trol.idrol='$this->lcIdRol'";
				$pcsql=$this->filtro($sql);
				if($laRow=$this->proximo($pcsql))
				{
					$dependencia=true;
				}
			
			$this->desconectar();
			return $dependencia;
		}

		function consultar_modulos()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT tmodulo_trol.idmodulo,nombremod,orden FROM tmodulo,tmodulo_trol WHERE tmodulo_trol.idrol='$this->lcIdRol' AND tmodulo_trol.idmodulo=tmodulo.idmodulo";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;
				$Fila[$cont]['j']=$cont;
				$Fila[$cont]['active'] = ($cont==0) ? 'active' : '';

				$cont++;
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_modulos_asignados()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT idmodulo,nombremod,estatusmod,(SELECT orden FROM tmodulo_trol WHERE idrol='$this->lcIdRol' AND idmodulo=tmodulo.idmodulo)as orden,(SELECT COUNT(*)as cantidad FROM tmodulo WHERE estatusmod='1')as cantidad FROM tmodulo ";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					$Fila[$cont]['checked']=($laRow['orden'])?'checked':'';
					$Fila[$cont]['disabled']=(!$laRow['orden'])?'disabled':'';
					$Fila[$cont]['cantidad']=$laRow['cantidad'];
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_modulos_menu()
		{
			$this->conectar();
			$cont=0;
			$sql="SELECT tmodulo.* FROM tmodulo,tmodulo_trol WHERE tmodulo_trol.idrol='$this->lcIdRol' AND tmodulo_trol.idmodulo=tmodulo.idmodulo ORDER BY orden ASC";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]=$laRow;
				$cont++;
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_servicios_menu($IdModulo, $visible = "AND visibleser='1'")
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT tservicio_trol.idservicio,nombreser,enlaceser,visibleser,orden FROM tservicio_trol,tservicio WHERE idrol='$this->lcIdRol' AND idmodulo='$IdModulo' AND tservicio_trol.idservicio=tservicio.idservicio $visible ORDER BY orden ASC";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_servicios()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT tservicio_trol.idservicio,nombreser,enlaceser,visibleser,orden FROM tservicio_trol,tservicio WHERE idrol='$this->lcIdRol' AND idmodulo='$this->lcModulo' AND tservicio_trol.idservicio=tservicio.idservicio ORDER BY visibleser DESC";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					

					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function consultar_servicios_asignados()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT tservicio.idservicio,nombreser,enlaceser,visibleser,(SELECT idservicio FROM tservicio_trol WHERE idrol='$this->lcIdRol' AND idservicio=tservicio.idservicio)as checked,(SELECT orden FROM tservicio_trol WHERE idrol='$this->lcIdRol' AND idservicio=tservicio.idservicio)as orden,(SELECT COUNT(*)as cantidad FROM tservicio WHERE estatusser='1')as cantidad FROM tservicio WHERE idmodulo='$this->lcModulo' ORDER BY visibleser DESC";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont]=$laRow;
					$Fila[$cont]['checked']=($laRow['checked'])?'checked':'';
					$Fila[$cont]['disabled']=(!$laRow['checked'])?'disabled':'';
					$Fila[$cont]['hide']=(!$laRow['visibleser'])?'hide':'';
					$Fila[$cont]['etiqueta']=(!$laRow['visibleser'])?'No aplica Orden':'Orden';
					$Fila[$cont]['cantidad']=$laRow['cantidad'];

					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}


		function consultar_rol()
		{
			$this->conectar();
			$sql="SELECT * FROM trol WHERE idrol='$this->lcIdRol'";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
			}
			$this->desconectar();
			return $Fila;
		}


		function registrar_rol()
		{
			$this->conectar();
			$sql="INSERT INTO trol (nombrerol)VALUES(UPPER('$this->lcNombre'))";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_rol()
		{
			$this->conectar();
			$sql="UPDATE trol SET estatusrol='0' WHERE idrol='$this->lcIdRol' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_rol()
		{
			$this->conectar();
			$sql="UPDATE trol SET estatusrol='1' WHERE idrol='$this->lcIdRol' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_rol()
		{
			$this->conectar();
			$sql="UPDATE trol SET nombrerol=UPPER('$this->lcNombre') WHERE idrol='$this->lcIdRol' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function asignar_modulo()
		{
			$this->conectar();
			$this->begin();
			$sql="DELETE FROM tmodulo_trol WHERE idrol='$this->lcIdRol' ";
			$this->ejecutar($sql);
			for($i=0;$i<count($this->lcModulo);$i++) 
			{
				$idModulo=$this->lcModulo[$i];
				$Orden=$this->lcOrden[$i];
				$sql="INSERT INTO tmodulo_trol (idrol,idmodulo,orden)VALUES('$this->lcIdRol','$idModulo','$Orden')";
				$lnHecho=$this->ejecutar($sql);
				if(!$lnHecho)
				{
					$this->rollback();
					break;
				}
			}
			if($lnHecho)
			{
				$this->commit();
			}
			$this->desconectar();
			return $lnHecho;
		}

		function quitar_servicios()
		{
			$this->conectar();
			$sql="DELETE FROM tservicio_trol WHERE idrol='$this->lcIdRol' ";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function asignar_servicio()
		{
			$this->conectar();
			$this->begin();
			for($i=0;$i<count($this->lcServicio);$i++) 
			{
				$idservicio=$this->lcServicio[$i];
				$Orden=$this->lcOrden[$i];
				$sql="INSERT INTO tservicio_trol (idrol,idservicio)VALUES('$this->lcIdRol','$idservicio')";
				$lnHecho=$this->ejecutar($sql);
				if(!$lnHecho)
				{
					$this->rollback();
					break;
				}
			}
			if($lnHecho)
			{
				$this->commit();
			}
			$this->desconectar();
			return $lnHecho;
		}
	}
?>