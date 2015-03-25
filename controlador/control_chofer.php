<?php
	session_start();
	require_once("../clases/clase_chofer.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjChofer=new clsChofer;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjChofer->set_Chofer($_POST['idchofer']);
	$lobjChofer->set_Codigo($_POST['idcodigopre']);
	$lobjChofer->set_Factura($_POST['tfactura_idfactura']);
	$lobjChofer->set_Observacion($_POST['observacionpre']);
	$lobjChofer->set_Estatus($_POST['estatuspre']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_chofer':
			$_SESSION['mensaje']='al registrar un tipo producto';

			if($lobjChofer->registrar_chofer())
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
			header('location:../vista/?modulo=chofer/chofer');
		break;
		case 'consultar_chofer':
			if($lachoferes=$lobjChofer->consultar_choferes())
			{
				$option='<option value=""></option>';
				for($i=0;$i<count($lachoferes);$i++)
				{
					$option.='<option value="'.$lachoferes[$i]['idchofer'].'">'.$lachoferes[$i]['descripciontip'].'</option>';
				}	
			}
			else
			{
				$option='<option>No se han encontrado registros</option>';
			}
			echo $option;
		break;
		case 'editar_chofer':
			$_SESSION['mensaje']='al editar el chofer';
			if($lobjChofer->editar_chofer())
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
			header('location:../vista/?modulo=chofer/chofer');
		break;
		case 'eliminar_chofer':
			$_SESSION['mensaje']='al desactivar el chofer';
			if($lobjChofer->eliminar_chofer())
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
			header('location:../vista/?modulo=chofer/chofer');
		break;
		case 'restaurar_chofer':
			$_SESSION['mensaje']='al restaurar el chofer';
			if($lobjChofer->restaurar_chofer())
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

			header('location:../vista/?modulo=chofer/chofer');
		break;
		default:
			header('location:../vista/?modulo=chofer/chofer');
		break;
	}

?>