<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_chofer.php');
require_once('../clases/clase_documento.php');
$lobjChofer = new clsChofer;
$lobjDocumento = new clsDocumento;

switch ($vista) {
        case 'chofer':
        $lachofers = $lobjChofer->consultar_choferes();
        $ObjSistema->consultar_opciones('?modulo=chofer/consultar_chofer', $opciones['btn_consultar'], '?modulo=chofer/registrar_chofer', $opciones['btn_registrar'], '?modulo=chofer/eliminar_chofer', $opciones['btn_eliminar'], '?modulo=chofer/eliminar_chofer', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);

        $HTML = $ObjSistema->get_cuerpo('chofer,choferes','#,?modulo=chofer/chofer','chofer','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/template_choferes.html") ? file_get_contents("chofer/template_choferes.html") : '');
		$HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        if($lachofers)
        	$HTML = $ObjSistema->render_regex('LISTADO_CHOFERES', $lachofers);
        else
        	$HTML = $ObjSistema->reemplazar_vacio('LISTADO_CHOFERES', '');

        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($opciones);
        break;
        case 'registrar_chofer':
        $ladocumentos = $lobjDocumento->consultar_documentos_tipo('Chofer');
        $prefijo_chofer=$ObjSistema->consultar_prefijo('chofer');

        $HTML = $ObjSistema->get_cuerpo('chofer,Choferes,Registrar chofer','#,?modulo=chofer/chofer,#','chofer','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/registrar_chofer.html") ? file_get_contents("chofer/registrar_chofer.html") : '',
                            'inicial_rif'=>'V',
                            'prefijo_chofer'=>$prefijo_chofer);
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);

        if($ladocumentos)
                $HTML = $ObjSistema->render_regex('LISTADO_DOCUMENTOS', $ladocumentos);
        else
                $HTML = $ObjSistema->reemplazar_vacio('LISTADO_DOCUMENTOS', '');

        $ObjSistema->set_cuerpo($HTML);
        break;
        case 'consultar_chofer':
        $lobjChofer->set_Chofer($id);
        $lobjDocumento->set_Chofer($id);
        $lachofer= $lobjChofer->consultar_chofer();
        $ladocumentos_chofer = $lobjDocumento->consultar_documentos_chofer();


        $HTML = $ObjSistema->get_cuerpo('chofer,Choferes,Consultar chofer','#,?modulo=chofer/chofer,#','chofer','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/consultar_chofer.html") ? file_get_contents("chofer/consultar_chofer.html") : '');
        $HTML = $ObjSistema->render($diccionario);        
        $ObjSistema->set_cuerpo($HTML);
        
        $HTML = $ObjSistema->render($lachofer);   
        $ObjSistema->set_cuerpo($HTML);

        if($ladocumentos_chofer)
                $HTML = $ObjSistema->render_regex('LISTADO_DOCUMENTOS_CHOFER', $ladocumentos_chofer);
        else
                $HTML = $ObjSistema->reemplazar_vacio('LISTADO_DOCUMENTOS_CHOFER', '');

        $ObjSistema->set_cuerpo($HTML);

        for($i=0;$i<count($ladocumentos_chofer);$i++)
        {
                $lobjDocumento->set_Documento($ladocumentos_chofer[$i]['iddocumento']);
                $ladocumentos = $lobjDocumento->consultar_documentos_tipo('Chofer');
                if($ladocumentos)
                        $HTML = $ObjSistema->render_regex('LISTADO_DOCUMENTOS'.$i, $ladocumentos);
                else
                        $HTML = $ObjSistema->reemplazar_vacio('LISTADO_DOCUMENTOS'.$i, '');
                
                $ObjSistema->set_cuerpo($HTML);
        }

        
        break;
        case 'documento':
        $ladocumentos = $lobjDocumento->consultar_documentos();
        $ObjSistema->consultar_opciones('?modulo=chofer/consultar_documento', $opciones['btn_consultar'], '?modulo=chofer/registrar_documento', $opciones['btn_registrar'], '?modulo=chofer/eliminar_documento', $opciones['btn_eliminar'], '?modulo=chofer/eliminar_documento', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);

        $HTML = $ObjSistema->get_cuerpo('chofer,Documentos','#,?modulo=chofer/documento','documento','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/template_documentos.html") ? file_get_contents("chofer/template_documentos.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        if($ladocumentos)
                $HTML = $ObjSistema->render_regex('LISTADO_DOCUMENTOS', $ladocumentos);
        else
                $HTML = $ObjSistema->reemplazar_vacio('LISTADO_DOCUMENTOS', '');

        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($opciones);
        break;
        case 'registrar_documento':

        $HTML = $ObjSistema->get_cuerpo('chofer,Documentos,Registrar documento','#,?modulo=chofer/documento,#','documento','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/registrar_documento.html") ? file_get_contents("chofer/registrar_documento.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        break;
        case 'consultar_documento':
        $lobjDocumento->set_Documento($id);
        $ladocumento= $lobjDocumento->consultar_documento();

        $HTML = $ObjSistema->get_cuerpo('chofer,Documentos,Consultar documento','#,?modulo=chofer/documento,#','documento','chofer');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("chofer/consultar_documento.html") ? file_get_contents("chofer/consultar_documento.html") : '');
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