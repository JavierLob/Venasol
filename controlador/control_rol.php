<?php
	session_start();	
	require_once("../clases/clase_rol.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjRol=new clsRol;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjRol->set_Rol($_POST['idrol']);
	$lobjRol->set_Nombre($_POST['nombrerol']);
	$lobjRol->set_Modulo($_POST['idmodulo']);
	$lobjRol->set_Orden($_POST['orden']);
	$lobjRol->set_Servicio($_POST['idservicio']);
	$operacion=$_POST['operacion'];
	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');

	switch ($operacion) 
	{
		case 'registrar_rol':
			$_SESSION['mensaje']='al registrar un rol';
			if($lobjRol->registrar_rol())
			{
				$_SESSION['resultado']='Éxito';
				$_SESSION['resultado_color']='success';
				$_SESSION['icono_mensaje']='check-circle';
			}
			else
			{	
				$_SESSION['resultado']='Error';
				$_SESSION['resultado_color']='danger';
				$_SESSION['icono_mensaje']='times-circle';

			}
			header('location:../vista/?modulo=seguridad/rol');
		break;
		case 'editar_rol':
			$_SESSION['mensaje']='al modificar el rol';
			if($lobjRol->editar_rol())
			{
				$_SESSION['resultado']='Éxito';
				$_SESSION['resultado_color']='success';
				$_SESSION['icono_mensaje']='check-circle';
			}
			else
			{	
				$_SESSION['resultado']='Error';
				$_SESSION['resultado_color']='danger';
				$_SESSION['icono_mensaje']='times-circle';
			}
			header('location:../vista/?modulo=seguridad/rol');
		break;
		case 'eliminar_rol':
			$_SESSION['mensaje']='al desactivar el rol';
			if($lobjRol->eliminar_rol())
			{
				$_SESSION['resultado']='Éxito';
				$_SESSION['resultado_color']='success';
				$_SESSION['icono_mensaje']='check-circle';
			}
			else
			{	
				$_SESSION['resultado']='Error';
				$_SESSION['resultado_color']='danger';
				$_SESSION['icono_mensaje']='times-circle';
			}
			header('location:../vista/?modulo=seguridad/rol');
		break;
		case 'restaurar_rol':
			$_SESSION['mensaje']='al restaurar el rol';
			if($lobjRol->restaurar_rol())
			{
				$_SESSION['resultado']='Éxito';
				$_SESSION['resultado_color']='success';
				$_SESSION['icono_mensaje']='check-circle';
			}
			else
			{	
				$_SESSION['resultado']='Error';
				$_SESSION['resultado_color']='danger';
				$_SESSION['icono_mensaje']='times-circle';
			}
			header('location:../vista/?modulo=seguridad/rol');
		break;
		case 'asignar_modulo':
			$_SESSION['mensaje']='al asignar módulos';

			$hecho=$lobjRol->asignar_modulo();
			if($hecho)
			{
				$_SESSION['resultado']='Éxito';
				$_SESSION['resultado_color']='success';
				$_SESSION['icono_mensaje']='check-circle';
			}
			else
			{	
				$_SESSION['resultado']='Error';
				$_SESSION['resultado_color']='danger';
				$_SESSION['icono_mensaje']='times-circle';
			}
			header('location:../vista/?modulo=seguridad/asignar_servicio');			
		break;
		case 'asignar_servicio':
            $laModulos=$lobjRol->consultar_modulos_menu();
            $lobjRol->quitar_servicios();            
			$_SESSION['mensaje']='al asignar servicios';

				for ($i=0; $i <count($laModulos);$i++)
				{
					if($_POST['idservicio'.$i])
					{
						$lobjRol->set_Servicio($_POST['idservicio'.$i]);
						$lobjRol->set_Orden($_POST['orden'.$i]);
						$hecho=$lobjRol->asignar_servicio();
					}
				}
			
			if($hecho)
			{
				$_SESSION['resultado']='Éxito';
				$_SESSION['resultado_color']='success';
				$_SESSION['icono_mensaje']='check-circle';
			}
			else
			{	
				$_SESSION['resultado']='Error';
				$_SESSION['resultado_color']='danger';
				$_SESSION['icono_mensaje']='times-circle';
			}
			header('location:../vista/?modulo=seguridad/asignar_servicio');			

		break;

	}

?>