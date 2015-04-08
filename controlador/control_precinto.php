<?php
	session_start();
	require_once("../clases/clase_precinto.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjPrecinto=new clsPrecinto;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjPrecinto->set_Precinto($_POST['idprecinto']);
	$lobjPrecinto->set_Codigo($_POST['idcodigopre']);
	$lobjPrecinto->set_Factura($_POST['tfactura_idfactura']);
	$lobjPrecinto->set_Observacion($_POST['observacionpre']);
	$lobjPrecinto->set_Estatus($_POST['estatuspre']);
	$lobjPrecinto->set_Grupo($_POST['grupopre']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_precinto':
			$_SESSION['mensaje']='al registrar un tipo producto';

			if($lobjPrecinto->registrar_precinto())
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
			header('location:../vista/?modulo=precinto/precinto');
		break;
		case 'registrar_precinto_ajax':
			if($lobjPrecinto->registrar_precinto_ajax())
			{
				echo '1';
			}
			else
			{
				echo '0';
			}
		break;
		case 'validar_repetido':
			if($lobjPrecinto->validar_repetido())
			{
				echo '1';
			}
			else
			{
				echo '0';
			}
		break;
		case 'consultar_precinto':
			if($laprecintos=$lobjPrecinto->consultar_precintos_activos())
			{
				$option='<option value=""></option>';
				for($i=0;$i<count($laprecintos);$i++)
				{
					$option.='<option value="'.$laprecintos[$i]['idprecinto'].'">'.$laprecintos[$i]['idcodigopre'].'</option>';
				}	
			}
			else
			{
				$option='<option>No se han encontrado registros</option>';
			}
			echo $option;
		break;
		case 'editar_precinto':
			$_SESSION['mensaje']='al editar el precinto';
			if($lobjPrecinto->editar_precinto())
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
			header('location:../vista/?modulo=precinto/precinto');
		break;
		case 'eliminar_precinto':
			$_SESSION['mensaje']='al desactivar el precinto';
			if($lobjPrecinto->eliminar_precinto())
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
			header('location:../vista/?modulo=precinto/precinto');
		break;
		case 'restaurar_precinto':
			$_SESSION['mensaje']='al restaurar el precinto';
			if($lobjPrecinto->restaurar_precinto())
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

			header('location:../vista/?modulo=precinto/precinto');
		break;
		default:
			header('location:../vista/?modulo=precinto/precinto');
		break;
	}

?>