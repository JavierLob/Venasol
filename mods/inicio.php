<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_factura.php');
require_once('../clases/clase_cliente.php');
require_once('../clases/clase_producto.php');
$lobjFactura = new clsFactura;
$lobjCliente = new clsCliente;
$lobjProducto = new clsProducto;

switch ($vista) {
        default:
                $lafactura=$lobjFactura->venta_mensual();
	        	$template_html = $ObjSistema->get_cuerpo('','','','');
	        	$la_facturas = $lobjFactura->consultar_ultimas_facturas();
                $diccionario =array('cuerpo' => file_exists("template_inicio.html") ? file_get_contents("template_inicio.html") : '');
                $ObjSistema->set_cuerpo($template_html);
                $HTML = $ObjSistema->render($diccionario);

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($lafactura);
                
                /**
                 * @see Ultimas 5 Facturas
                 */

                $ObjSistema->set_cuerpo($HTML);
                if($la_facturas)
                	$HTML =$ObjSistema->render_regex('LISTADO_FACTURAS', $la_facturas);
                else
                	$HTML =$ObjSistema->reemplazar_vacio('LISTADO_FACTURAS', '<td colspan="6">No tiene facturas registradas...</td>');

                /** 
                 * @see Top 5 Clientes
                 */
                $la_clientes = $lobjCliente->consultar_ultimos_clientes();

                $ObjSistema->set_cuerpo($HTML);
                if($la_clientes)
                	$HTML =$ObjSistema->render_regex('LISTADO_CLIENTES', $la_clientes);
                else
                	$HTML =$ObjSistema->reemplazar_vacio('LISTADO_CLIENTES', '<td colspan="4">No tiene clientes facturados...</td>');

                /** 
                 * @see Top 5 Productos
                 */
                $la_Productos = $lobjProducto->consultar_ultimos_productos();

                $ObjSistema->set_cuerpo($HTML);
                if($la_Productos)
                	$HTML =$ObjSistema->render_regex('LISTADO_PRODUCTOS', $la_Productos);
                else
                	$HTML =$ObjSistema->reemplazar_vacio('LISTADO_PRODUCTOS', '<td colspan="4">No tiene productos facturados...</td>');
        break;
}

?>
