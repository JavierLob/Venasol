<?php
$vista = $ObjSistema->CapturarVista();
require_once("../clases/clase_configuracion.php");
require_once('../clases/clase_documento.php');
$lobjDocumento = new clsDocumento;
$lobjConfiguracion = new clsConfiguracion;

switch ($vista) {
        case 'documento':
        $ladocumentos = $lobjDocumento->consultar_documentos();
        $ObjSistema->consultar_opciones('?modulo=configuracion/consultar_documento', $opciones['btn_consultar'], '?modulo=configuracion/registrar_documento', $opciones['btn_registrar'], '?modulo=configuracion/eliminar_documento', $opciones['btn_eliminar'], '?modulo=configuracion/eliminar_documento', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);

        $HTML = $ObjSistema->get_cuerpo('Configuracion,Documentos','#,?modulo=configuracion/documento','documento','configuracion');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("configuracion/template_documentos.html") ? file_get_contents("configuracion/template_documentos.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        if($ladocumentos)
                $HTML = $ObjSistema->render_regex('LISTADO_DOCUMENTOS', $ladocumentos);
        else
                $HTML = $ObjSistema->reemplazar_vacio('LISTADO_DOCUMENTOS', '');

        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($opciones);
        break;
        case 'configuracion':
        $laconfiguracion=$lobjConfiguracion->consultar_configuracion();
        $HTML = $ObjSistema->get_cuerpo('configuracion','?modulo=configuracion/configuracion','configuracion','configuracion');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("configuracion/configuracion.html") ? file_get_contents("configuracion/configuracion.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);

        $HTML = $ObjSistema->render($laconfiguracion);   
        $ObjSistema->set_cuerpo($HTML);
        break;
        case 'registrar_documento':

        $HTML = $ObjSistema->get_cuerpo('configuracion,Documentos,Registrar documento','#,?modulo=configuracion/documento,#','documento','configuracion');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("configuracion/registrar_documento.html") ? file_get_contents("configuracion/registrar_documento.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        break;
        case 'consultar_documento':
        $lobjDocumento->set_Documento($id);
        $ladocumento= $lobjDocumento->consultar_documento();

        $HTML = $ObjSistema->get_cuerpo('configuracion,Documentos,Consultar documento','#,?modulo=configuracion/documento,#','documento','configuracion');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("configuracion/consultar_documento.html") ? file_get_contents("configuracion/consultar_documento.html") : '');
        $HTML = $ObjSistema->render($diccionario);        
        $ObjSistema->set_cuerpo($HTML);
        
        $HTML = $ObjSistema->render($ladocumento);   
        $ObjSistema->set_cuerpo($HTML);
        break;
	default:
	       header("location: ./");
	break;
}

?>
