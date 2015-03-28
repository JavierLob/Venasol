<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_cliente.php');
require_once('../clases/clase_chofer.php');
require_once('../clases/clase_vehiculo.php');
require_once('../clases/clase_precinto.php');
$lobjCliente = new clsCliente;
$lobjChofer = new clsChofer;
$lobjVehiculo = new clsVehiculo;
$lobjPrecinto = new clsPrecinto;
switch ($vista) {
        case 'iniciar_factura':
            if($_POST['operacion']=='iniciar_factura')
            {
                $HTML = $ObjSistema->get_cuerpo('factura,facturar','#,?modulo=factura/iniciar_factura','factura','factura');
                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("factura/facturar.html") ? file_get_contents("factura/facturar.html") : '', 'operacion'=>'registrar_factura');
                $HTML = $ObjSistema->render($diccionario);

                $id = $_POST['idcliente'];
                $lobjCliente->set_Cliente($id);
                $datos_cliente = $lobjCliente->consultar_cliente();

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($datos_cliente);

                /**
                 * @see choferes
                 */
                $ObjSistema->set_cuerpo($HTML);
                $lachofers = $lobjChofer->consultar_choferes();

                if($lachofers)
                    $HTML = $ObjSistema->render_regex('LISTADO_CHOFER', $lachofers);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_CHOFER', '<option value="">No se han encontrado choferes...</option>');

                /**
                 * @see vehiculos
                 */

                $lavehiculos = $lobjVehiculo->consultar_vehiculos();
                $ObjSistema->set_cuerpo($HTML);
                if($lavehiculos)
                    $HTML = $ObjSistema->render_regex('LISTADO_VEHICULO', $lavehiculos);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_VEHICULO', '<option value="">No se han encontrado vehiculos...</option>');

                /**
                 * @see precintos
                 */

                $laprecintos = $lobjPrecinto->consultar_precintos_activos();
                $ObjSistema->set_cuerpo($HTML);
                if($laprecintos)
                    $HTML = $ObjSistema->render_regex('LISTADO_PRECINTOS', $laprecintos);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_PRECINTOS', '<option value="">No se han encontrado precintos...</option>');
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