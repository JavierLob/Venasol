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
	case 'chofer':
		include_once("../mods/chofer.php");
	break;
	case 'cliente':
		include_once("../mods/cliente.php");
	break;
	case 'vehiculo':
		include_once("../mods/vehiculo.php");
	break;
	case 'factura':
		include_once("../mods/factura.php");
	break;
	case 'configuracion':
		include_once("../mods/configuracion.php");
	break;
	case 'consultar_perfil':
        $lobjUsuario->set_Usuario($_SESSION['usuario']);
        $datos_usuario = $lobjUsuario->consultar_usuario();
        $HTML = $ObjSistema->get_cuerpo('Perfil','./,#','usuario','usuario');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario = array('cuerpo' => file_exists("perfil/consultar_perfil.html") ? file_get_contents("perfil/consultar_perfil.html") : '',
                            'operacion'=>'editar_perfil',
                            'Funcion' => 'Consultar Perfil',
                            'funcion'=> 'editar',
                            'icono'=> 'edit'
                            );

        $HTML = $ObjSistema->render($diccionario);
        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($datos_usuario);
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
