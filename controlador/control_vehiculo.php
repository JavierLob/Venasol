<?php
	session_start();
	require_once("../clases/clase_vehiculo.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjVehiculo=new clsVehiculo;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjVehiculo->set_Vehiculo($_POST['idvehiculo']);
	$lobjVehiculo->set_Codigo($_POST['idcodigoveh']);
	$lobjVehiculo->set_Alias($_POST['aliasveh']);
	$lobjVehiculo->set_Placa($_POST['placaveh']);
	$lobjVehiculo->set_Ano($_POST['anoveh']);
	$lobjVehiculo->set_Color($_POST['colorveh']);
	$lobjVehiculo->set_Modelo($_POST['idmodelo']);
	$lobjVehiculo->set_Observacion($_POST['observacionveh']);
	$lobjVehiculo->set_Estatus($_POST['estatusveh']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_vehiculo':
			$_SESSION['mensaje']='al registrar un vehiculo';

			if($lobjVehiculo->registrar_vehiculo())
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
			header('location:../vista/?modulo=vehiculo/vehiculo');
		break;
		case 'consultar_vehiculo':
			if($lavehiculos=$lobjVehiculo->consultar_vehiculos())
			{
				$option='<option value=""></option>';
				for($i=0;$i<count($lavehiculos);$i++)
				{
					$option.='<option value="'.$lavehiculos[$i]['idvehiculo'].'">'.$lavehiculos[$i]['aliasveh'].'</option>';
				}	
			}
			else
			{
				$option='<option>No se han encontrado registros</option>';
			}
			echo $option;
		break;
		case 'editar_vehiculo':
			$_SESSION['mensaje']='al editar el vehiculo';
			if($lobjVehiculo->editar_vehiculo())
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
			header('location:../vista/?modulo=vehiculo/vehiculo');
		break;
		case 'eliminar_vehiculo':
			$_SESSION['mensaje']='al desactivar el vehiculo';
			if($lobjVehiculo->eliminar_vehiculo())
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
			header('location:../vista/?modulo=vehiculo/vehiculo');
		break;
		case 'restaurar_vehiculo':
			$_SESSION['mensaje']='al restaurar el vehiculo';
			if($lobjVehiculo->restaurar_vehiculo())
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

			header('location:../vista/?modulo=vehiculo/vehiculo');
		break;
		default:
			header('location:../vista/?modulo=vehiculo/vehiculo');
		break;
	}

?>