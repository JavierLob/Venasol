<?php
	session_start();
	require_once("../clases/clase_servicio.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjServicio=new clsServicio;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjServicio->set_Servicio($_POST['idservicio']);
	$lobjServicio->set_Nombre($_POST['nombreser']);
	$lobjServicio->set_Enlace($_POST['enlaceser']);
	$lobjServicio->set_Visible($_POST['visibleser']);
	$lobjServicio->set_Modulo($_POST['idmodulo']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_servicio':
			$_SESSION['mensaje']='al registrar un servicio';

			if($lobjServicio->registrar_servicio())
			{
				$_SESSION['resultado']='Éxito';
				$_SESSION['resultado_color']='success';
				$_SESSION['icono_mensaje']='check-circle';
				//$lobjBitacora->set_Datos($_SERVER['HTTP_REFERER'],$ldFecha,$lcReal_ip,'Registrar','Cargar datos','*','tservicio','','',$_SESSION['usuario'],$operacion); //envia los datos a la clase bitacora
   				//$lobjBitacora->registrar_bitacora();//registra los datos en la tabla tbitacora.
			}
			else
			{
				$_SESSION['resultado']='Error';
				$_SESSION['resultado_color']='danger';
				$_SESSION['icono_mensaje']='times-circle';	
			}
			header('location:../vista/?modulo=seguridad/servicio');
		break;
		case 'editar_servicio':
			$_SESSION['mensaje']='al editar el servicio';
			if($lobjServicio->editar_servicio())
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
			header('location:../vista/?modulo=seguridad/servicio');
		break;
		case 'eliminar_servicio':
			$_SESSION['mensaje']='al desactivar el servicio';
			if($lobjServicio->eliminar_servicio())
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
			header('location:../vista/?modulo=seguridad/servicio');
		break;
		case 'restaurar_servicio':
			$_SESSION['mensaje']='al restaurar el servicio';
			if($lobjServicio->restaurar_servicio())
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

			header('location:../vista/?modulo=seguridad/servicio');
		break;
		default:
			header('location:../vista/?modulo=seguridad/servicio');
		break;
	}

?>