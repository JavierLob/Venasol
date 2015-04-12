<?php
//ini_set('error_reporting', E_ALL);
session_start();
require_once('../clases/clase_usuario.php');
$lobjUsuario= new clsUsuario;

$operacion = (isset($_POST['operacion'])) ? $_POST['operacion'] : $_GET['operacion'];

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$lobjUsuario->set_Usuario($_POST['idusuario']);
$lobjUsuario->set_Correo($_POST['emailusu']);
$lobjUsuario->set_Clave($_POST['cedula']);
$lobjUsuario->set_Rol($_POST['trol_idrol']);
$lobjUsuario->set_Nombre($_POST['nombreusu']);
$lobjUsuario->set_Persona($_POST['cedula']);
switch ($operacion) {
	case 'iniciar_sesion':
			$lobjUsuario->set_Usuario($usuario);
			$lobjUsuario->set_Clave($clave);
			if($datos_usuario = $lobjUsuario->login())
			{
				$_SESSION['usuario'] = $datos_usuario['idusuario'];
				$_SESSION['nombrerol'] = $datos_usuario['nombrerol'];
				$_SESSION['idrol'] = $datos_usuario['trol_idrol'];
				$_SESSION['nombreusu'] = $datos_usuario['nombreusu'];
				$_SESSION['clave'] = $clave;

				header("location: ../vista/?modulo=inicio");
			}
			else
			{
				$_SESSION['msj']='El usuario y/o clave que ingresó son incorrectos.';
		 		header("location: ../vista/");
			}
		break;
	case 'registrar_usuario':
		$_SESSION['mensaje']='al registrar un usuario';
		if(!$lobjUsuario->consultar_usuario())
		{
			if($lobjUsuario->registrar_usuario())
			{
				$_SESSION['resultado']='Éxito';
				$_SESSION['resultado_color']='success';
				$_SESSION['icono_mensaje']='check-circle';
			}
			else
			{
				$_SESSION['resultado']='Error';
				$_SESSION['resultado_color']='danger';
				$_SESSION['icono_mensaje']='times-circle';	
			}
		}
		else
		{
			$_SESSION['resultado']='Error';
			$_SESSION['resultado_color']='danger';
			$_SESSION['icono_mensaje']='times-circle';	
		}
		header('location:../vista/?modulo=seguridad/usuario');
	break;
	case 'editar_usuario':
		$_SESSION['mensaje']='al editar el usuario';
		if($lobjUsuario->editar_usuario())
		{
			$_SESSION['resultado']='Éxito';
			$_SESSION['resultado_color']='success';
			$_SESSION['icono_mensaje']='check-circle';
			
		}
		else
		{	
			$_SESSION['resultado']='Error';
			$_SESSION['resultado_color']='danger';
			$_SESSION['icono_mensaje']='times-circle';
		}
		header('location:../vista/?modulo=seguridad/usuario');
	break;
	case 'eliminar_usuario':
		$_SESSION['mensaje']='al desactivar el usuario';
		if($lobjUsuario->eliminar_usuario())
		{
			$_SESSION['resultado']='Éxito';
			$_SESSION['resultado_color']='success';
			$_SESSION['icono_mensaje']='check-circle';
		}
		else
		{	
			$_SESSION['resultado']='Error';
			$_SESSION['resultado_color']='danger';
			$_SESSION['icono_mensaje']='times-circle';
		}
		header('location:../vista/?modulo=seguridad/usuario');
	break;
	case 'restaurar_usuario':
		$_SESSION['mensaje']='al restaurar el usuario';
		if($lobjUsuario->restaurar_usuario())
		{
			$_SESSION['resultado']='Éxito';
			$_SESSION['resultado_color']='success';
			$_SESSION['icono_mensaje']='check-circle';
		}
		else
		{	
			$_SESSION['resultado']='Error';
			$_SESSION['resultado_color']='danger';
			$_SESSION['icono_mensaje']='times-circle';
		}

		header('location:../vista/?modulo=seguridad/usuario');
	break;
	default:
		 header("location: ../");
		break;
}
?>