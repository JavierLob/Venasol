<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_marca.php');
require_once('../clases/clase_vehiculo.php');
require_once('../clases/clase_accesorio.php');
require_once('../clases/clase_modelo.php');
$lobjMarca = new clsMarca;
$lobjVehiculo = new clsVehiculo;
$lobjAccesorio = new clsAccesorio;
$lobjModelo = new clsModelo;

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
        case 'vehiculo':
                $lavehiculos = $lobjVehiculo->consultar_vehiculos();
                $ObjSistema->consultar_opciones('?modulo=vehiculo/consultar_vehiculo', $opciones['btn_consultar'], '?modulo=vehiculo/registrar_vehiculo', $opciones['btn_registrar'], '?modulo=vehiculo/eliminar_vehiculo', $opciones['btn_eliminar'], '?modulo=vehiculo/eliminar_vehiculo', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);
                $HTML = $ObjSistema->get_cuerpo('vehiculo,vehiculos','#,?modulo=vehiculo/vehiculo','vehiculo','vehiculo');

                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("vehiculo/template_vehiculos.html") ? file_get_contents("vehiculo/template_vehiculos.html") : '');
                $HTML = $ObjSistema->render($diccionario);
                
                $ObjSistema->set_cuerpo($HTML);
                if($lavehiculos)
                    $HTML = $ObjSistema->render_regex('LISTADO_VEHICULOS', $lavehiculos);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_VEHICULOS', '');

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($opciones);
        break;
        case 'registrar_vehiculo':
        $lamarcas = $lobjMarca->consultar_marcas_tipo('1');
        $HTML = $ObjSistema->get_cuerpo('vehiculo,vehiculos,Registrar vehiculo','#,?modulo=vehiculo/vehiculo,#','vehiculo','vehiculo');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("vehiculo/registrar_vehiculo.html") ? file_get_contents("vehiculo/registrar_vehiculo.html") : '',
                            'operacion'=>'registrar_vehiculo',
                            'Funcion' => 'Registrar',
                            'funcion'=> 'registrar',
                            'icono'=> 'plus',
                            'idvehiculo'=>'',
                            'placaveh'=>'',
                            'anoveh'=>'',
                            'colorveh'=>'',
                            'aliasveh'=>'',
                            'selected_marca'=>'',
                            'selected_modelo'=>'',
                            'observacionveh'=>''
                            );

        $HTML = $ObjSistema->render($diccionario);
         $ObjSistema->set_cuerpo($HTML);
        if($lamarcas)
            $HTML = $ObjSistema->render_regex('LISTADO_MARCAS', $lamarcas);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MARCAS', '');
        break;
        case 'consultar_vehiculo':
        $lamarcas = $lobjMarca->consultar_marcas_tipo('1');
        $lobjVehiculo->set_Vehiculo($id);
        $datos_vehiculo = $lobjVehiculo->consultar_vehiculo();
        $HTML = $ObjSistema->get_cuerpo('vehiculo,vehiculos,Consultar/Editar vehiculo','#,?modulo=vehiculo/vehiculo,#','vehiculo','vehiculo');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("vehiculo/registrar_vehiculo.html") ? file_get_contents("vehiculo/registrar_vehiculo.html") : '',
                            'operacion'=>'editar_vehiculo',
                            'Funcion' => 'Consultar / Editar',
                            'funcion'=> 'editar',
                            'icono'=> 'edit'
                            );

        $lobjModelo->set_Marca($datos_vehiculo['idmarca']);
        $lamodelos = $lobjModelo->consultar_modelos_marca();
        

        $HTML = $ObjSistema->render($diccionario);
        $ObjSistema->set_cuerpo($HTML);
        
        for($i=0; $i <count($lamarcas); $i++)
            $lamarcas[$i]['selected_marca'] = ($lamarcas[$i]['idmarca'] == $datos_vehiculo['idmarca']) ? 'selected' : '';
        
        for($i=0; $i <count($lamodelos); $i++)
            $lamodelos[$i]['selected_modelo'] = ($lamodelos[$i]['idmodelo'] == $datos_vehiculo['tmodelo_idmodelo']) ? 'selected' : '';

        if($lamarcas)
            $HTML = $ObjSistema->render_regex('LISTADO_MARCAS', $lamarcas);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MARCAS', '');

        $ObjSistema->set_cuerpo($HTML);
        
        if($lamodelos)
            $HTML = $ObjSistema->render_regex('LISTADO_MODELOS', $lamodelos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MODELOS', '');
        
        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($datos_vehiculo);
        break;

        case 'accesorio':
                $laaccesorios = $lobjAccesorio->consultar_accesorios();
                $ObjSistema->consultar_opciones('?modulo=vehiculo/consultar_accesorio', $opciones['btn_consultar'], '?modulo=vehiculo/registrar_accesorio', $opciones['btn_registrar'], '?modulo=vehiculo/eliminar_accesorio', $opciones['btn_eliminar'], '?modulo=vehiculo/eliminar_accesorio', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);
                $HTML = $ObjSistema->get_cuerpo('vehiculo,accesorios','#,?modulo=vehiculo/accesorio','accesorio','vehiculo');

                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("vehiculo/template_accesorios.html") ? file_get_contents("vehiculo/template_accesorios.html") : '');
                $HTML = $ObjSistema->render($diccionario);
                
                $ObjSistema->set_cuerpo($HTML);
                if($laaccesorios)
                    $HTML = $ObjSistema->render_regex('LISTADO_ACCESORIOS', $laaccesorios);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_ACCESORIOS', '');

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($opciones);
        break;
        case 'registrar_accesorio':
        $lamarcas = $lobjMarca->consultar_marcas_tipo('0');
        $HTML = $ObjSistema->get_cuerpo('vehiculo,accesorios,Registrar accesorio','#,?modulo=vehiculo/accesorio,#','accesorio','vehiculo');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("vehiculo/registrar_accesorio.html") ? file_get_contents("vehiculo/registrar_accesorio.html") : '',
                            'operacion'=>'registrar_accesorio',
                            'Funcion' => 'Registrar',
                            'funcion'=> 'registrar',
                            'icono'=> 'plus',
                            'idaccesorio'=>'',
                            'placaacc'=>'',
                            'anoacc'=>'',
                            'coloracc'=>'',
                            'capacidadacc'=>'',
                            'unidadmedidaacc'=>'',
                            'selected_marca'=>'',
                            'selected_modelo'=>'',
                            'observacionacc'=>''
                            );

        $HTML = $ObjSistema->render($diccionario);
         $ObjSistema->set_cuerpo($HTML);
        if($lamarcas)
            $HTML = $ObjSistema->render_regex('LISTADO_MARCAS', $lamarcas);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MARCAS', '');
        break;
        case 'consultar_accesorio':
        $lamarcas = $lobjMarca->consultar_marcas_tipo('0');
        $lobjAccesorio->set_Accesorio($id);
        $datos_accesorio = $lobjAccesorio->consultar_accesorio();
        $HTML = $ObjSistema->get_cuerpo('vehiculo,accesorios,Consultar/Editar accesorio','#,?modulo=vehiculo/accesorio,#','accesorio','vehiculo');
        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("vehiculo/registrar_accesorio.html") ? file_get_contents("vehiculo/registrar_accesorio.html") : '',
                            'operacion'=>'editar_accesorio',
                            'Funcion' => 'Consultar / Editar',
                            'funcion'=> 'editar',
                            'icono'=> 'edit'
                            );

        $lobjModelo->set_Marca($datos_accesorio['idmarca']);
        $lamodelos = $lobjModelo->consultar_modelos_marca();
        

        $HTML = $ObjSistema->render($diccionario);
        $ObjSistema->set_cuerpo($HTML);
        
        for($i=0; $i <count($lamarcas); $i++)
            $lamarcas[$i]['selected_marca'] = ($lamarcas[$i]['idmarca'] == $datos_accesorio['idmarca']) ? 'selected' : '';
        
        for($i=0; $i <count($lamodelos); $i++)
            $lamodelos[$i]['selected_modelo'] = ($lamodelos[$i]['idmodelo'] == $datos_accesorio['tmodelo_idmodelo']) ? 'selected' : '';

        if($lamarcas)
            $HTML = $ObjSistema->render_regex('LISTADO_MARCAS', $lamarcas);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MARCAS', '');

        $ObjSistema->set_cuerpo($HTML);
        
        if($lamodelos)
            $HTML = $ObjSistema->render_regex('LISTADO_MODELOS', $lamodelos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MODELOS', '');
        
        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($datos_accesorio);
        break;
	    default:
		header("location: ./");
		break;
}

?>
