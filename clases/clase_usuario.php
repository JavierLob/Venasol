<?php

	require_once('../nucleo/ModeloConectPg.php');

	class clsUsuario extends clsModelo_pg
	{
		private $lcUsuario;
		private $lcClave;
		private $lnIdRol;
		private $lnIdPersona;
		private $lcNombre;
		private $lnIdUsuarioGoogle;
		private $lcCorreo;
		private $lcProfile;
		private $lcProfileImage;


		function set_Usuario($pcUsuario)
		{
			$this->lcUsuario=$pcUsuario;
		}

		function set_Profile($pcProfile)
		{
			$this->lcProfile=$pcProfile;
		}

		function set_ProfileImage($pcProfileImage)
		{
			$this->lcProfileImage=$pcProfileImage;
		}

		function set_Correo($pcCorreo)
		{
			$this->lcCorreo=$pcCorreo;
		}

		function set_IdUsuarioGoogle($pcIdUsuarioGoogle)
		{
			$this->lnIdUsuarioGoogle=$pcIdUsuarioGoogle;
		}

		function set_Clave($pcClave)
		{
			$this->lcClave=$pcClave;
		}

		function set_Rol($pcIdRol)
		{
			$this->lnIdRol=$pcIdRol;
		}

		function set_Persona($pnIdPersona)
		{
			$this->lnIdPersona=$pnIdPersona;
		}

		function set_Nombre($pcNombre)
		{
			$this->lcNombre=$pcNombre;
		}

		function set_Email($pcEmail)
		{
			$this->lcEmail=$pcEmail;
		}

		function login()
		{
			#tusuario, tclave, trol
			$this->conectar();
			$sql="SELECT tusuario.*, trol.nombrerol 
					FROM tusuario, trol, tclave 
				   WHERE tusuario.idusuario = '$this->lcUsuario' 
				     AND tclave.tusuario_idusuario = tusuario.idusuario 
				     AND tclave.clavecla = md5('$this->lcClave') 
				     AND trol.idrol = tusuario.trol_idrol
				     AND tusuario.estatususu='1'
				     AND tclave.estatuscla='1';";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila = $laRow;
			}
			$this->desconectar();
			return $Fila;
		}

		function listado_usuarios()
		{
			$cont=0;
			$this->conectar();
			$sql="SELECT tusuario.*, trol.nombrerol 
					FROM tusuario, trol 
				   WHERE trol.idrol = tusuario.trol_idrol;";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]['idusuario']=$laRow['idusuario'];
				$Fila[$cont]['nombrerol']=$laRow['nombrerol'];
				$Fila[$cont]['nombreusu']=$laRow['nombreusu'];
				$Fila[$cont]['emailusu']=$laRow['emailusu'];
				$Fila[$cont]['cedula']=$laRow['cedula'];
				$Fila[$cont]['estatususu']=$laRow['estatususu'];
				$Fila[$cont]['nro']=($cont+1);
				$Fila[$cont]['estatus_color']=($laRow['estatususu'])?'success':'danger';
				$Fila[$cont]['estatususu'] = ($laRow['estatususu']) ? 'Activo' : 'Inactivo';
				$Fila[$cont]['titulo'] = ($laRow['estatususu']) ? 'Desactivar' : 'Restaurar';
				$Fila[$cont]['color_boton'] = ($laRow['estatususu']) ? 'danger' : 'warning';
				$Fila[$cont]['funcion'] = ($laRow['estatususu']) ? 'eliminar' : 'restaurar';
				$Fila[$cont]['icono'] = ($laRow['estatususu']) ? 'times' : 'refresh';
				$cont++;
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_usuarios()
		{
			$cont=0;
			$this->conectar();
			$sql="SELECT * FROM tusuario";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]['idusuario']=$laRow['idusuario'];
				$Fila[$cont]['nombreusu']=$laRow['nombreusu'];
				$Fila[$cont]['emailusu']=$laRow['emailusu'];
				$Fila[$cont]['cedula']=$laRow['cedula'];
				$Fila[$cont]['estatususu']=$laRow['estatususu'];
				$cont++;
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_usuario()
		{
			$this->conectar();
			$sql="SELECT tusuario.*,nombrerol,idrol FROM tusuario,trol WHERE idusuario='$this->lcUsuario' AND idrol=trol_idrol  AND trol.idrol=trol_idrol";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila=$laRow;
				$Fila['cedula']=trim($laRow['cedula']);
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_usuario_google()
		{
			$this->conectar();
			$sql="SELECT COUNT(google_id) as usercount FROM tgoogle_users WHERE google_id='$this->lnIdUsuarioGoogle'";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila=($laRow['usercount']=='0')?false:true;
			}
			$this->desconectar();
			return $Fila;
		}


		function consultar_datos_usuario()
		{
			$this->conectar();
			$sql="SELECT tusuario.idusuario as id,nombrerol,idrol,nombreusu,TO_DAYS(fechafincla)as fechafincla,TO_DAYS(NOW())as fechaactual,estatususu,(SELECT CONCAT_WS(' / ',DATE_FORMAT(fechaacc,'%d-%m-%Y %h:%i %p'),DATE_FORMAT(fecha_salidaacc,'%d-%m-%Y %h:%i %p')) FROM tacceso WHERE id=idusuario ORDER BY idacceso DESC LIMIT 1)as ultimo_acceso FROM tusuario,trol,tclave WHERE tusuario.idusuario='$this->lcUsuario' AND tusuario.idusuario=tusuario_idusuario AND idrol=trol_idrol AND estatuscla='1'";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$Fila['idusuario']=$laRow['id'];
				$Fila['nombrerol']=$laRow['nombrerol'];
				$Fila['nombreusu']=$laRow['nombreusu'];
				$Fila['caduca_clave']=($laRow['fechafincla']-$laRow['fechaactual']>0)?$laRow['fechafincla']-$laRow['fechaactual']. ' Días':'Caducó';
				$Fila['ultimo_acceso']=$laRow['ultimo_acceso'];
				$Fila['estatususu']=($laRow['estatususu'])?'Activo':'Bloqueado';
			}
			$this->desconectar();
			return $Fila;
		}

		function consultar_primer_acceso()
		{
			$llEncontro=true;
			$this->conectar();
			$sql="SELECT count(*) AS cantidad FROM tacceso WHERE idusuario='$this->lcUsuario'";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				if($laRow['cantidad']>0)
				{
					$llEncontro=false;
				}
			}
			$this->desconectar();
			return $llEncontro;
		}

		function consultar_tiempo_conexion()
		{
			$llEncontro=true;
			$this->conectar();
			$sql="SELECT * FROM tusuario WHERE idusuario='$this->lcUsuario' AND (SELECT tiempoconexion FROM tsistema)<TIMESTAMPDIFF(MINUTE,ultima_actividadusu,NOW())";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{	
				$llEncontro=false;
			}
			$this->desconectar();
			return $llEncontro;
		}

		
		function cerrar_accesos_activos()
		{
			$this->conectar();
			$sql="UPDATE tacceso,tusuario SET fecha_salidaacc=NOW(),estatusacc='0' WHERE tacceso.idusuario='$this->lcUsuario' AND tacceso.idusuario=tusuario.idusuario AND estatusacc='1' AND (SELECT tiempoconexion FROM tsistema)<TIMESTAMPDIFF(MINUTE,ultima_actividadusu,NOW())";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function actualizar_tour()
		{
			$this->conectar();
			$sql="UPDATE tusuario SET tour='1' WHERE idusuario='$this->lcUsuario'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		

		function actualizar_actividad($idacceso)
		{
			$this->conectar();
			$sql="UPDATE tusuario,tacceso SET ultima_actividadusu=NOW(),ultima_actividadacc=NOW() WHERE tusuario.idusuario='$this->lcUsuario' AND tusuario.idusuario=tacceso.idusuario AND idacceso='$idacceso' AND estatusacc='1'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function registrar_usuario()
		{
			$this->conectar();
			$sql="INSERT INTO tusuario(idusuario, nombreusu, emailusu, estatususu, trol_idrol, cedula, ultima_actividadusu, intentos_fallidos)
			 VALUES ('$this->lcUsuario',UPPER('$this->lcNombre'),UPPER('$this->lcCorreo'),'1','$this->lnIdRol','$this->lnIdPersona', NOW(), 0)";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			$this->registrar_clave();
			return $lnHecho;
		}

		function registrar_clave()
		{
			$this->conectar();
			$sql="INSERT INTO tclave(
           				clavecla, fechainiciocla, fechafincla, estatuscla, tusuario_idusuario)
    			VALUES (md5('$this->lcClave'), NOW(), '2021-12-12', 1, '$this->lcUsuario');";
			$lnHecho=$this->ejecutar($sql);	
			$this->desconectar();	
			return $lnHecho;
		}

		function desactivar_clave()
		{
			$this->conectar();
			$sql="UPDATE tclave SET estatuscla=0, fechafincla = NOW() WHERE tusuario_idusuario = '$this->lcUsuario';";
			$lnHecho=$this->ejecutar($sql);	
			$this->desconectar();	
			return $lnHecho;
		}

		function registrar_usuario_google()
		{
			$this->conectar();
			$sql=" INSERT INTO tgoogle_users (google_id, google_name, google_email, google_link, google_picture_link) 
			VALUES ('$this->lnIdUsuarioGoogle', '$this->lcUsuario','$this->lcCorreo','$this->lcProfile','$this->lcProfileImage')";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();	
			return $lnHecho;
		}

		function editar_usuario()
		{
			$this->conectar();
			$sql="UPDATE tusuario SET nombreusu=UPPER('$this->lcNombre'), emailusu=UPPER('$this->lcCorreo'),trol_idrol='$this->lnIdRol',cedula='$this->lnIdPersona' WHERE idusuario='$this->lcUsuario'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function editar_perfil()
		{
			$this->conectar();
			$sql="UPDATE tusuario SET emailusu=UPPER('$this->lcCorreo') WHERE idusuario='$this->lcUsuario'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_usuario()
		{
			$this->conectar();
			$sql="UPDATE tusuario SET estatususu='0' WHERE idusuario='$this->lcUsuario'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function restaurar_usuario()
		{
			$this->conectar();
			$sql="UPDATE tusuario SET estatususu='1' WHERE idusuario='$this->lcUsuario'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function bloquear_usuario()
		{
			$this->conectar();
			$sql="UPDATE tusuario SET 
				estatususu='0' WHERE idusuario='$this->lcUsuario'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function cantidad_intentos()
		{
			$this->conectar();
			$sql="UPDATE tusuario SET 
				intentos_fallidos=intentos_fallidos+1 WHERE idusuario='$this->lcUsuario'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function eliminar_accesos_fallidos()
		{
			$this->conectar();
			$sql="UPDATE tusuario SET 
				intentos_fallidos='0' WHERE idusuario='$this->lcUsuario'";
			$lnHecho=$this->ejecutar($sql);			
			$this->desconectar();
			return $lnHecho;
		}

		function consultar_accesos_fallidos()
		{
			$this->conectar();
			$sql="SELECT * FROM tusuario WHERE idusuario='$this->lcUsuario' ";
			$pcsql=$this->filtro($sql);
			if($laRow=$this->proximo($pcsql))
			{
				$intentos_fallidos=$laRow['intentos_fallidos'];
			}
			$this->desconectar();
			return $intentos_fallidos;
		}
		function consultar_bloqueados()
		{
			$this->conectar();
			$cont=0;
				$sql="SELECT * FROM tusuario WHERE  estatususu='0';";
				$pcsql=$this->filtro($sql);
				while($laRow=$this->proximo($pcsql))
				{
					$Fila[$cont][0]=$laRow['idusuario'];
					$Fila[$cont][1]=$laRow['nombreusu'];
					$Fila[$cont][2]=$laRow['emailusu'];
					$Fila[$cont][3]=$laRow['cedula'];
					$Fila[$cont][4]=$laRow['estatususu'];
					$cont++;
				}
			
			$this->desconectar();
			return $Fila;
		}

		function listado_cambio_clave()
		{
			$cont=0;
			$this->conectar();
			$sql="SELECT *,TO_DAYS(fechafincla)as fechafincla_dias,TO_DAYS(NOW())as fechaactual FROM tusuario,tclave WHERE idusuario='$this->lcUsuario' AND idusuario=tusuario_idusuario";
			$pcsql=$this->filtro($sql);
			while($laRow=$this->proximo($pcsql))
			{
				$Fila[$cont]['idusuario']=$laRow['idusuario'];
				$Fila[$cont]['idclave']=$laRow['idclave'];
				$Fila[$cont]['fechainiciocla']=$laRow['fechainiciocla'];
				$Fila[$cont]['fechafincla']=$laRow['fechafincla'];
				$Fila[$cont]['estatuscla']=($laRow['estatuscla']==1)?'Activa':'Inactiva';
				$Fila[$cont]['caduca_clave']=($laRow['fechafincla_dias']-$laRow['fechaactual']>0)?$laRow['fechafincla_dias']-$laRow['fechaactual']. ' Días':'Caducó';
				$cont++;
			}
			$this->desconectar();
			return $Fila;
		}

	}
?>