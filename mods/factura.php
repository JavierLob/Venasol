<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_cliente.php');
$lobjCliente = new clsCliente;
switch ($vista) {
        case 'iniciar_factura':
            if($_POST['operacion']=='iniciar_factura')
            {
                $HTML = $ObjSistema->get_cuerpo('factura,facturar','#,?modulo=factura/iniciar_factura','factura','factura');
                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("factura/facturar.html") ? file_get_contents("factura/facturar.html") : '');
                $HTML = $ObjSistema->render($diccionario);

                $id = $_POST['idcliente'];
                $lobjCliente->set_Cliente($id);
                $datos_cliente = $lobjCliente->consultar_cliente();

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($datos_cliente);
            }
            else
            {
                header('location: ./?modulo=factura/iniciar');
            }
        break;
	    default:
		    $HTML = $ObjSistema->get_cuerpo('factura,iniciar factura','#,?modulo=factura/inicio','factura','factura');
            $ObjSistema->set_cuerpo($HTML);
            $diccionario =array('cuerpo' => file_exists("factura/iniciar_factura.html") ? file_get_contents("factura/iniciar_factura.html") : '');
            $HTML = $ObjSistema->render($diccionario);
		break;
}

?>
