<?php
//ini_set('error_reporting', E_ALL);
session_start();
require_once('../clases/clase_usuario.php');
$lobjUsuario= new clsUsuario;

$operacion = (isset($_POST['operacion'])) ? $_POST['operacion'] : $_GET['operacion'];

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

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
	default:
		 header("location: ../");
		break;
}
?>