<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_chofer.php');
$lobjChofer = new clsChofer;

switch ($vista) {
        case 'chofer':
        $lachofers = $lobjChofer->consultar_choferes();
        $ObjSistema->consultar_opciones('?modulo=chofer/consultar_chofer', $opciones['btn_consultar'], '?modulo=chofer/registrar_chofer', $opciones['btn_registrar'], '?modulo=chofer/eliminar_chofer', $opciones['btn_eliminar'], '?modulo=chofer/eliminar_chofer', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);

        $HTML = $ObjSistema->get_cuerpo('chofer,choferes','#,?modulo=chofer/chofer','chofer','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/template_choferes.html") ? file_get_contents("chofer/template_choferes.html") : '');
		$HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        if($lachoferes)
        	$HTML = $ObjSistema->render_regex('LISTADO_CHOFERES', $lachoferes);
        else
        	$HTML = $ObjSistema->reemplazar_vacio('LISTADO_CHOFERES', '');

        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($opciones);
        break;
        case 'registrar_chofer':

        $HTML = $ObjSistema->get_cuerpo('chofer,Choferes,Registrar chofer','#,?modulo=chofer/chofer,#','chofer','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/registrar_chofer.html") ? file_get_contents("chofer/registrar_chofer.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        break;
        case 'consultar_chofer':
        $lobjChofer->set_Chofer($id);
        $lachofer= $lobjChofer->consultar_chofer();

        $HTML = $ObjSistema->get_cuerpo('chofer,Choferes,Consultar chofer','#,?modulo=chofer/chofer,#','chofer','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/consultar_chofer.html") ? file_get_contents("chofer/consultar_chofer.html") : '');
        $HTML = $ObjSistema->render($diccionario);        
        $ObjSistema->set_cuerpo($HTML);
        
        $HTML = $ObjSistema->render($lachofer);   
        $ObjSistema->set_cuerpo($HTML);


        break;
	    default:
		header("location: ./");
		break;
}

?>
