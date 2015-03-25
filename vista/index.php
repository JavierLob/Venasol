<?php 
session_start();
require_once("../clases/clase_sistema.php");
include '../libreria/google-login-api/index.php';

$ObjSistema = new clsGlobal();

$modulo = (isset($_SESSION['usuario']) AND !empty($_SESSION['usuario'])) ? $ObjSistema->CapturarModulo() : '';
$id = $ObjSistema->CapturarId();
switch ($modulo) {
	case 'inicio':
		$template_html = $ObjSistema->get_cuerpo('','','','');
		$diccionario =array('cuerpo' => file_exists("template_inicio.html") ? file_get_contents("template_inicio.html") : ''
							);
		$ObjSistema->set_cuerpo($template_html);
		$HTML = $ObjSistema->render($diccionario);
	break;
	case 'seguridad':
		include_once("../mods/seguridad.php");
	break;
	case 'producto':
		include_once("../mods/producto.php");
	break;
	case 'precinto':
		include_once("../mods/precinto.php");
	break;
	case 'logout':
		unset($_SESSION['usuario']);
		unset($_SESSION['nombrerol']);
		unset($_SESSION['idrol']);
		unset($_SESSION['nombreusu']);
		unset($_SESSION['clave']);
		unset($_SESSION['msj']);
		session_destroy();
		header("location: ./");
	break;
	default:

		if(isset($_SESSION['usuario']) AND !empty($_SESSION['usuario']))
			header("location: ./?modulo=inicio");

		$mensaje = (isset($_SESSION["msj"]) AND !empty($_SESSION["msj"]))? $_SESSION["msj"] : ''; unset($_SESSION['msj']);

		$template_html = file_get_contents('template_login.html');
		$diccionario =array('msj' => (isset($mensaje) AND !empty($mensaje)) ? 'alert("'.$mensaje.'");' : '',
			 				'conect_google' => $authUrl
							);
		$ObjSistema->set_cuerpo($template_html);
		$HTML = $ObjSistema->render($diccionario);
	break;
}

print($HTML);
?>
