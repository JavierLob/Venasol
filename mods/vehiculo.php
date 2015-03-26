<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_marca.php');
$lobjMarca = new clsMarca;

switch ($vista) {
        case 'marca':
                $lamarcas = $lobjMarca->consultar_marcas();
                $ObjSistema->consultar_opciones('?modulo=vehiculo/consultar_marca', $opciones['btn_consultar'], '?modulo=vehiculo/registrar_marca', $opciones['btn_registrar'], '?modulo=vehiculo/eliminar_marca', $opciones['btn_eliminar'], '?modulo=vehiculo/eliminar_marca', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);
                $HTML = $ObjSistema->get_cuerpo('vehiculo,marcas','#,?modulo=vehiculo/marca','marca','vehiculo');

                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("vehiculo/template_marcas.html") ? file_get_contents("vehiculo/template_marcas.html") : '');
        		$HTML = $ObjSistema->render($diccionario);
                
                $ObjSistema->set_cuerpo($HTML);
                if($lamarcas)
                	$HTML = $ObjSistema->render_regex('LISTADO_MARCAS', $lamarcas);
                else
                	$HTML = $ObjSistema->reemplazar_vacio('LISTADO_MARCAS', '');

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($opciones);
        break;
        case 'registrar_marca':
        $HTML = $ObjSistema->get_cuerpo('vehiculo,marcas,Registrar marca','#,?modulo=vehiculo/marca,#','marca','vehiculo');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("vehiculo/registrar_marca.html") ? file_get_contents("vehiculo/registrar_marca.html") : '',
                            'operacion'=>'registrar_marca',
                            'Funcion' => 'Registrar',
                            'funcion'=> 'registrar',
                            'icono'=> 'plus',
                            'idmarca'=>'',
                            'descripcionmar'=>'',
                            'observacionmar'=>'',
                            'estatusmar'=>''
                            );

        $HTML = $ObjSistema->render($diccionario);
        
        break;
        case 'consultar_marca':
        $lobjMarca->set_Marca($id);
        $datos_marca = $lobjMarca->consultar_marca();
        $HTML = $ObjSistema->get_cuerpo('vehiculo,marcas,Consultar/Editar marca','#,?modulo=vehiculo/marca,#','marca','vehiculo');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario = array('cuerpo' => file_exists("vehiculo/registrar_marca.html") ? file_get_contents("vehiculo/registrar_marca.html") : '',
                            'operacion'=>'editar_marca',
                            'Funcion' => 'Consultar / Editar',
                            'funcion'=> 'editar',
                            'icono'=> 'edit'
                            );

        $HTML = $ObjSistema->render($diccionario);
        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($datos_marca);
        break;
        case 'registrar_modelo':
        $lobjMarca->set_Marca($id);
        $datos_marca = $lobjMarca->consultar_marca();
        $HTML = $ObjSistema->get_cuerpo('vehiculo,marcas,Registrar modelos','#,?modulo=vehiculo/marca,#','modelo','vehiculo');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario = array('cuerpo' => file_exists("vehiculo/registrar_modelo.html") ? file_get_contents("vehiculo/registrar_modelo.html") : '',
                            'operacion'=>'registrar_modelo',
                            'Funcion' => 'Registrar',
                            'funcion'=> 'registrar',
                            'icono'=> 'plus'
                            );

        $HTML = $ObjSistema->render($diccionario);
        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($datos_marca);
        break;
	    default:
		header("location: ./");
		break;
}

?>
