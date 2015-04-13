<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_factura.php');
$lobjFactura = new clsFactura;

switch ($vista) {
        default:
                $lafactura=$lobjFactura->venta_mensual();
	        $template_html = $ObjSistema->get_cuerpo('','','','');
                $diccionario =array('cuerpo' => file_exists("template_inicio.html") ? file_get_contents("template_inicio.html") : '');
                $ObjSistema->set_cuerpo($template_html);
                $HTML = $ObjSistema->render($diccionario);

                 $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($lafactura);

        break;
}

?>
