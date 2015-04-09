<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_cliente.php');
require_once('../clases/clase_chofer.php');
require_once('../clases/clase_vehiculo.php');
require_once('../clases/clase_precinto.php');
require_once('../clases/clase_factura.php');
$lobjCliente = new clsCliente;
$lobjChofer = new clsChofer;
$lobjVehiculo = new clsVehiculo;
$lobjPrecinto = new clsPrecinto;
$lobjFactura = new clsFactura;
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
        case 'consultar_factura':
            $lobjFactura->set_Factura($id);
            $datos_factura = $lobjFactura->consultar_factura();
            if($datos_factura)
            {
                $HTML = $ObjSistema->get_cuerpo('factura,modificar factura','#,?modulo=factura/iniciar_factura','factura','factura');
                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("factura/consultar_factura.html") ? file_get_contents("factura/consultar_factura.html") : '', 'operacion'=>'modificar_factura');
                $HTML = $ObjSistema->render($diccionario);

                $id = $datos_factura['idcliente'];
                $lobjCliente->set_Cliente($id);
                $datos_cliente = $lobjCliente->consultar_cliente();

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($datos_cliente);

                /**
                 * @see choferes
                 */
                $ObjSistema->set_cuerpo($HTML);
                $lachofers = $lobjChofer->consultar_choferes();

                for($i=0; $i < count($lachofers); $i++)
                    $lachofers[$i]['selected'] = ($lachofers[$i]['idchofer'] == $datos_factura['idchofer']) ? 'selected' : '';

                if($lachofers)
                    $HTML = $ObjSistema->render_regex('LISTADO_CHOFER', $lachofers);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_CHOFER', '<option value="">No se han encontrado choferes...</option>');

                /**
                 * @see vehiculos
                 */

                $lavehiculos = $lobjVehiculo->consultar_vehiculos();

                for($i=0; $i < count($lavehiculos); $i++)
                    $lavehiculos[$i]['selected'] = ($lavehiculos[$i]['idvehiculo'] == $datos_factura['idvehiculo']) ? 'selected' : '';

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
                    $HTML = $ObjSistema->render_regex('LISTADO_PRECINTOS', $laprecintos, false);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_PRECINTOS', '<option value="">No se han encontrado precintos...</option>');
            

                $laFactura_Productos=$lobjFactura->consultar_productos_factura();

                $ObjSistema->set_cuerpo($HTML);
                if($laFactura_Productos)
                    $HTML = $ObjSistema->render_regex('LISTADO_PRODUCTOS', $laFactura_Productos);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_PRODUCTOS', '<tr><td colspan="5">No existen productos cargados...</td></tr>');

                $laFactura_Precintos=$lobjFactura->consultar_precintos_factura_b();

                $ObjSistema->set_cuerpo($HTML);
                if($laFactura_Precintos)
                    $HTML = $ObjSistema->render_regex('LISTADO_PRECINTOS_SELECT', $laFactura_Precintos);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_PRECINTOS_SELECT', '<option value="">No se han encontrado precintos...</option>');


                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($datos_factura);
            }
            else
            {
                header('location: ./?modulo=factura/iniciar');
            }
        break;
        case 'listar':
            $lafacturas = $lobjFactura->consultar_facturas();
            
            $HTML = $ObjSistema->get_cuerpo('factura,listado de facturas','?modulo=factura/inicio,?modulo=factura/listar','factura','factura');
            $ObjSistema->set_cuerpo($HTML);
            $diccionario =array('cuerpo' => file_exists("factura/listar_factura.html") ? file_get_contents("factura/listar_factura.html") : '');
            $HTML = $ObjSistema->render($diccionario);

             $ObjSistema->set_cuerpo($HTML);
                if($lafacturas)
                    $HTML = $ObjSistema->render_regex('LISTADO_FACTURAS', $lafacturas);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_FACTURAS', '');
        break;
	    default:
            $lafacturas = $lobjFactura->consultar_facturas();
		    
            $HTML = $ObjSistema->get_cuerpo('factura,iniciar factura','#,?modulo=factura/inicio','factura','factura');
            $ObjSistema->set_cuerpo($HTML);
            $diccionario =array('cuerpo' => file_exists("factura/iniciar_factura.html") ? file_get_contents("factura/iniciar_factura.html") : '');
            $HTML = $ObjSistema->render($diccionario);
		break;
}

?>
