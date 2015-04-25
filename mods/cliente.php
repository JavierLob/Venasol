<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_cliente.php');
$lobjCliente = new clsCliente;

switch ($vista) {
        case 'cliente':
                $laclientes = $lobjCliente->consultar_clientes();
                $ObjSistema->consultar_opciones('?modulo=cliente/consultar_cliente', $opciones['btn_consultar'], '?modulo=cliente/registrar_cliente', $opciones['btn_registrar'], '?modulo=cliente/eliminar_cliente', $opciones['btn_eliminar'], '?modulo=cliente/eliminar_cliente', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);

                $HTML = $ObjSistema->get_cuerpo('cliente,clientes','#,?modulo=cliente/cliente','cliente','cliente');

                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("cliente/template_clientes.html") ? file_get_contents("cliente/template_clientes.html") : '');
        		$HTML = $ObjSistema->render($diccionario);
                
                $ObjSistema->set_cuerpo($HTML);
                if($laclientes)
                	$HTML = $ObjSistema->render_regex('LISTADO_CLIENTES', $laclientes);
                else
                	$HTML = $ObjSistema->reemplazar_vacio('LISTADO_CLIENTES', '');

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($opciones);
        break;
        case 'registrar_cliente':
        $HTML = $ObjSistema->get_cuerpo('cliente,clientes,Registrar cliente','#,?modulo=cliente/cliente,#','cliente','cliente');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("cliente/registrar_cliente.html") ? file_get_contents("cliente/registrar_cliente.html") : '',
                            'operacion'=>'registrar_cliente',
                            'Funcion' => 'Registrar',
                            'funcion'=> 'registrar',
                            'icono'=> 'plus',
                            'idcliente'=>'',
                            'idcodigocli'=>'',
                            'rifcli'=>'V',
                            'inicial_rif'=>'V',
                            'razonsocial'=>'',
                            'direccioncli'=>'',
                            'correounocli'=>'',
                            'correodoscli'=>'',
                            'telefonounocli'=>'',
                            'telefonodoscli'=>'',
                            'observacioncli'=>'',
                            'estatuscli'=>''
                            );

        $HTML = $ObjSistema->render($diccionario);
        
        break;
        case 'consultar_cliente':
        $lobjCliente->set_Cliente($id);
        $datos_cliente = $lobjCliente->consultar_cliente();
        $HTML = $ObjSistema->get_cuerpo('cliente,clientes,Registrar cliente','#,?modulo=cliente/cliente,#','cliente','cliente');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario = array('cuerpo' => file_exists("cliente/registrar_cliente.html") ? file_get_contents("cliente/registrar_cliente.html") : '',
                            'operacion'=>'editar_cliente',
                            'Funcion' => 'Consultar / Editar',
                            'funcion'=> 'editar',
                            'icono'=> 'edit',
                            'inicial_rif'=>substr($datos_cliente['rifcli'], 0, 1)
                            );

        $HTML = $ObjSistema->render($diccionario);
        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($datos_cliente);
        break;
	    default:
		header("location: ./");
		break;
}

?>