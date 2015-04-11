<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_rol.php');
require_once('../clases/clase_modulo.php');
require_once('../clases/clase_servicio.php');
$lobjrol = new clsrol;
$lobjModulo = new clsModulo;
$lobjServicio = new clsServicio;

switch ($vista) {
        case 'rol':
                $ObjSistema->consultar_opciones('?modulo=seguridad/consultar_rol', $opciones['btn_consultar'], '?modulo=seguridad/registrar_rol', $opciones['btn_registrar'], '?modulo=seguridad/eliminar_rol', $opciones['btn_eliminar'], '?modulo=seguridad/eliminar_rol', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);
                $larols = $lobjrol->consultar_roles();

                $HTML = $ObjSistema->get_cuerpo('Seguridad,Rol','#,?modulo=seguridad/rol','rol','seguridad');

                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("seguridad/template_roles.html") ? file_get_contents("seguridad/template_roles.html") : '');
        		$HTML = $ObjSistema->render($diccionario);
                
                $ObjSistema->set_cuerpo($HTML);
                if($larols)
                	$HTML = $ObjSistema->render_regex('LISTADO_ROLES', $larols);
                else
                	$HTML = $ObjSistema->reemplazar_vacio('LISTADO_ROLES', '');

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($opciones);
        break;
        case 'modulo':
                $ObjSistema->consultar_opciones('?modulo=seguridad/consultar_modulo', $opciones['btn_consultar'], '?modulo=seguridad/registrar_modulo', $opciones['btn_registrar'], '?modulo=seguridad/eliminar_modulo', $opciones['btn_eliminar'], '?modulo=seguridad/eliminar_modulo', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);
                $lamodulos = $lobjModulo->consultar_modulos();

                $HTML = $ObjSistema->get_cuerpo('Seguridad,Módulo','#,?modulo=seguridad/modulo','modulo','seguridad');

                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("seguridad/template_modulos.html") ? file_get_contents("seguridad/template_modulos.html") : '');
                $HTML = $ObjSistema->render($diccionario);
                
                $ObjSistema->set_cuerpo($HTML);
                if($lamodulos)
                    $HTML = $ObjSistema->render_regex('LISTADO_MODULOS', $lamodulos);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MODULOS', '');

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($opciones);
        break;
        case 'servicio':
                $ObjSistema->consultar_opciones('?modulo=seguridad/consultar_servicio', $opciones['btn_consultar'], '?modulo=seguridad/registrar_servicio', $opciones['btn_registrar'], '?modulo=seguridad/eliminar_servicio', $opciones['btn_eliminar'], '?modulo=seguridad/eliminar_servicio', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);
                $laservicios = $lobjServicio->consultar_servicios();

                $HTML = $ObjSistema->get_cuerpo('Seguridad,Servicio','#,?modulo=seguridad/servicio','servicio','seguridad');

                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("seguridad/template_servicios.html") ? file_get_contents("seguridad/template_servicios.html") : '');
                $HTML = $ObjSistema->render($diccionario);
                
                $ObjSistema->set_cuerpo($HTML);
                if($laservicios)
                    $HTML = $ObjSistema->render_regex('LISTADO_SERVICIOS', $laservicios);
                else
                    $HTML = $ObjSistema->reemplazar_vacio('LISTADO_SERVICIOS', '');

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($opciones);
        break;
        case 'asignacion':
                $larols = $lobjrol->consultar_roles();
                
                $ObjSistema->set_cuerpo($ObjSistema->get_cuerpo('Seguridad,Asignación','#,?modulo=seguridad/asignacion','asignacion','seguridad'));

                $diccionario =array('cuerpo' => file_exists("seguridad/asignacion.html") ? file_get_contents("seguridad/asignacion.html") : '');
                
                $ObjSistema->set_cuerpo($ObjSistema->render($diccionario));
                if($larols)
                        $HTML = $ObjSistema->render_regex('LISTADO_ROLES', $larols);
                else
                        $HTML = $ObjSistema->reemplazar_vacio('LISTADO_ROLES', '');

                $ObjSistema->set_cuerpo($HTML);

                 if($larols)
                        $HTML = $ObjSistema->render_regex('LISTADO_TABS', $larols);
                else
                        $HTML = $ObjSistema->reemplazar_vacio('LISTADO_TABS', '');
                $ObjSistema->set_cuerpo($HTML);

                for($i=0;$i<count($larols);$i++)
                {                       
                        $lobjrol->set_Rol($larols[$i]['idrol']);
                        $lamodulos = $lobjrol->consultar_modulos();

                        if($lamodulos)
                            $HTML = $ObjSistema->render_regex('LISTADO_MODULOS_'.$i, $lamodulos);
                            else
                            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MODULOS_'.$i, '');
                        if(!$lamodulos)
                        {
                            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MODULOS_'.$i, '');
                            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_SERVICIOS_'.$i, '');                     

                        }
                        for($j=0;$j<count($lamodulos);$j++)
                        {
                                                              
                            $ObjSistema->set_cuerpo($HTML);

                            $lobjrol->set_Modulo($lamodulos[$j]['idmodulo']);
                            $laservicios = $lobjrol->consultar_servicios();

                            if($laservicios)
                            $HTML = $ObjSistema->render_regex('LISTADO_SERVICIOS_'.$j, $laservicios);
                            else
                                $HTML = $ObjSistema->reemplazar_vacio('LISTADO_SERVICIOS_'.$j, '<strong>Sin servicios asignados</strong>');

                            $ObjSistema->set_cuerpo($HTML);

                        }

                }

        break;
        case 'registrar_rol':
        $HTML = $ObjSistema->get_cuerpo('Seguridad,Rol,Registrar rol','#,?modulo=seguridad/rol,#','rol','seguridad');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("seguridad/registrar_rol.html") ? file_get_contents("seguridad/registrar_rol.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
      
        break;
        case 'consultar_servicio':
        $lobjServicio->set_Servicio($id);
        $laservicio = $lobjServicio->consultar_servicio();
        $lamodulos=$lobjModulo->consultar_modulos_servicio($laservicio['idmodulo']);

        $HTML = $ObjSistema->get_cuerpo('Seguridad,Servicio,Consultar servicio','#,?modulo=seguridad/servicio,#','servicio','seguridad');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("seguridad/consultar_servicio.html") ? file_get_contents("seguridad/consultar_servicio.html") : '');
        $HTML = $ObjSistema->render($diccionario);        
        $ObjSistema->set_cuerpo($HTML);
        
        
             
        if($lamodulos)
            $HTML = $ObjSistema->render_regex('LISTADO_MODULOS', $lamodulos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MODULOS', '');
        $ObjSistema->set_cuerpo($HTML);

        $HTML = $ObjSistema->render($laservicio);   
        $ObjSistema->set_cuerpo($HTML);

        break;
        case 'registrar_rol':
        $HTML = $ObjSistema->get_cuerpo('Seguridad,Rol,Registrar rol','#,?modulo=seguridad/rol,#','rol','seguridad');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("seguridad/registrar_rol.html") ? file_get_contents("seguridad/registrar_rol.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
      
        break;
        case 'consultar_rol':
        $lobjrol->set_Rol($id);
        $larol = $lobjrol->consultar_rol();

        $HTML = $ObjSistema->get_cuerpo('Seguridad,Rol,Consultar rol','#,?modulo=seguridad/rol,#','rol','seguridad');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("seguridad/consultar_rol.html") ? file_get_contents("seguridad/consultar_rol.html") : '');
        $HTML = $ObjSistema->render($diccionario);        
        $ObjSistema->set_cuerpo($HTML);
        
        $HTML = $ObjSistema->render($larol);        
        $ObjSistema->set_cuerpo($HTML);

        break;
        case 'registrar_rol':
        $HTML = $ObjSistema->get_cuerpo('Seguridad,Rol,Registrar rol','#,?modulo=seguridad/rol,#','rol','seguridad');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("seguridad/registrar_rol.html") ? file_get_contents("seguridad/registrar_rol.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
      
        break;
         case 'registrar_servicio':
         $lamodulos=$lobjModulo->consultar_modulos();
        $HTML = $ObjSistema->get_cuerpo('Seguridad,Servicio,Registrar rol','#,?modulo=seguridad/servicio,#','rol','seguridad');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("seguridad/registrar_servicio.html") ? file_get_contents("seguridad/registrar_servicio.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);

        if($lamodulos)
            $HTML = $ObjSistema->render_regex('LISTADO_MODULOS', $lamodulos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MODULOS', '');

        $ObjSistema->set_cuerpo($HTML);

      
        break;
        case 'asignar_modulo':
        $larols = $lobjrol->consultar_roles();
        $HTML = $ObjSistema->get_cuerpo('Seguridad,Asignación,Asignar módulos','#,?modulo=seguridad/asignacion,#','rol','seguridad');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("seguridad/asignar_modulo.html") ? file_get_contents("seguridad/asignar_modulo.html") : '');
        
        $ObjSistema->set_cuerpo($ObjSistema->render($diccionario));
        
        if($larols)
            $HTML = $ObjSistema->render_regex('LISTADO_ROLES', $larols);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_ROLES', '');

        break;
        case 'consultar_modulos_rol':
        $lobjrol->set_Rol($id);
        $lamodulos = $lobjrol->consultar_modulos_asignados();

        $HTML= file_exists("seguridad/listado_modulos.html") ? file_get_contents("seguridad/listado_modulos.html") : '';
        $ObjSistema->set_cuerpo($HTML);        

        if($lamodulos)
            $HTML = $ObjSistema->render_regex('LISTA_MODULOS', $lamodulos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTA_MODULOS', '');

        break;
         case 'asignar_servicio':
        $larols = $lobjrol->consultar_roles();
        $HTML = $ObjSistema->get_cuerpo('Seguridad,Asignación,Asignar servicios','#,?modulo=seguridad/asignacion,#','rol','seguridad');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("seguridad/asignar_servicio.html") ? file_get_contents("seguridad/asignar_servicio.html") : '');
        
        $ObjSistema->set_cuerpo($ObjSistema->render($diccionario));
        
        if($larols)
            $HTML = $ObjSistema->render_regex('LISTADO_ROLES', $larols);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_ROLES', '');

        break;
        case 'consultar_servicios_rol':
        $lobjrol->set_Rol($id);
        $lamodulos = $lobjrol->consultar_modulos();

        $HTML= file_exists("seguridad/listado_servicios.html") ? file_get_contents("seguridad/listado_servicios.html") : '';
        $ObjSistema->set_cuerpo($HTML);        

        if($lamodulos)
            $HTML = $ObjSistema->render_regex('LISTADO_MODULOS', $lamodulos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_MODULOS', '');

        $ObjSistema->set_cuerpo($HTML);        

       if($lamodulos)
            $HTML = $ObjSistema->render_regex('LISTADO_TABS', $lamodulos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_TABS', '');
        $ObjSistema->set_cuerpo($HTML);        

        for ($i=0; $i <count($lamodulos) ; $i++) 
        { 
            $lobjrol->set_Modulo($lamodulos[$i]['idmodulo']);
            $laservicios = $lobjrol->consultar_servicios_asignados();

            if($laservicios)
                $HTML = $ObjSistema->render_regex('LISTADO_SERVICIOS'.$i, $laservicios);
            else
                $HTML = $ObjSistema->reemplazar_vacio('LISTADO_SERVICIOS'.$i, '<p>No existen servicios registrados para este módulo.</p>');

        $ObjSistema->set_cuerpo($HTML);        

        }

        break;
	    default:
		header("location: ./");
		break;
}

?>
