<?php
	session_start();
	require_once("../clases/clase_accesorio.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjAccesorio=new clsAccesorio;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjAccesorio->set_Accesorio($_POST['idaccesorio']);
	$lobjAccesorio->set_Codigo($_POST['idcodigoacc']);
	$lobjAccesorio->set_Capacidad($_POST['capacidadacc']);
	$lobjAccesorio->set_UnidadMedida($_POST['unidadmedidaacc']);
	$lobjAccesorio->set_Placa($_POST['placaacc']);
	$lobjAccesorio->set_Ano($_POST['anoacc']);
	$lobjAccesorio->set_Color($_POST['coloracc']);
	$lobjAccesorio->set_Modelo($_POST['idmodelo']);
	$lobjAccesorio->set_Observacion($_POST['observacionacc']);
	$lobjAccesorio->set_Estatus($_POST['estatusacc']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_accesorio':
			$_SESSION['mensaje']='al registrar un accesorio';

			if($lobjAccesorio->registrar_accesorio())
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
			header('location:../vista/?modulo=vehiculo/accesorio');
		break;
		case 'consultar_accesorio':
			if($laaccesorios=$lobjAccesorio->consultar_accesorios())
			{
				$option='<option value="">Seleccione un accesorio</option>';
				for($i=0;$i<count($laaccesorios);$i++)
				{
					$option.='<option value="'.$laaccesorios[$i]['idaccesorio'].'">'.$laaccesorios[$i]['placaacc'].' '.$laaccesorios[$i]['coloracc'].' '.$laaccesorios[$i]['capacidadacc'].''.$laaccesorios[$i]['unidadmedidaacc'].'</option>';
				}	
			}
			else
			{
				$option='<option>No se han encontrado registros</option>';
			}
			echo $option;
		break;
		case 'editar_accesorio':
			$_SESSION['mensaje']='al editar el accesorio';
			if($lobjAccesorio->editar_accesorio())
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
			header('location:../vista/?modulo=vehiculo/accesorio');
		break;
		case 'eliminar_accesorio':
			$_SESSION['mensaje']='al desactivar el accesorio';
			if($lobjAccesorio->eliminar_accesorio())
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
			header('location:../vista/?modulo=vehiculo/accesorio');
		break;
		case 'restaurar_accesorio':
			$_SESSION['mensaje']='al restaurar el accesorio';
			if($lobjAccesorio->restaurar_accesorio())
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

			header('location:../vista/?modulo=vehiculo/accesorio');
		break;
		default:
			header('location:../vista/?modulo=vehiculo/accesorio');
		break;
	}

?>