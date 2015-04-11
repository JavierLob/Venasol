<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_precinto.php');
$lobjPrecinto = new clsPrecinto;

switch ($vista) {
        case 'precinto':
        $laprecintos = $lobjPrecinto->consultar_precintos();
        $ObjSistema->consultar_opciones('?modulo=precinto/consultar_precinto', $opciones['btn_consultar'], '?modulo=precinto/registrar_precinto', $opciones['btn_registrar'], '?modulo=precinto/eliminar_precinto', $opciones['btn_eliminar'], '?modulo=precinto/eliminar_precinto', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);

        $HTML = $ObjSistema->get_cuerpo('precinto,precintos','#,?modulo=precinto/precinto','precinto','precinto');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("precinto/template_precintos.html") ? file_get_contents("precinto/template_precintos.html") : '');
		$HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        if($laprecintos)
        	$HTML = $ObjSistema->render_regex('LISTADO_PRECINTOS', $laprecintos);
        else
        	$HTML = $ObjSistema->reemplazar_vacio('LISTADO_PRECINTOS', '');

        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($opciones);
        break;
        case 'registrar_precinto':

        $HTML = $ObjSistema->get_cuerpo('precinto,Precintos,Registrar precinto','#,?modulo=precinto/precinto,#','precinto','precinto');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("precinto/registrar_precinto.html") ? file_get_contents("precinto/registrar_precinto.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        break;
        case 'consultar_precinto':
        $lobjPrecinto->set_Precinto($id);
        $laprecinto= $lobjPrecinto->consultar_precinto();

        $HTML = $ObjSistema->get_cuerpo('precinto,Precintos,Consultar precinto','#,?modulo=precinto/precinto,#','precinto','precinto');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("precinto/consultar_precinto.html") ? file_get_contents("precinto/consultar_precinto.html") : '');
        $HTML = $ObjSistema->render($diccionario);        
        $ObjSistema->set_cuerpo($HTML);
        
        $HTML = $ObjSistema->render($laprecinto);   
        $ObjSistema->set_cuerpo($HTML);


        break;
	    default:
		header("location: ./");
		break;
}

?>
