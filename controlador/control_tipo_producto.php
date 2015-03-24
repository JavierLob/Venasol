<?php
	session_start();
	require_once("../clases/clase_tipo_producto.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjTipoProducto=new clsTipoProducto;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjTipoProducto->set_TipoProducto($_POST['idtipo_producto']);
	$lobjTipoProducto->set_Descripcion($_POST['descripciontip']);
	$lobjTipoProducto->set_Observacion($_POST['observaciontip']);
	$lobjTipoProducto->set_Estatus($_POST['estatustip']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_tipo_producto':
			$_SESSION['mensaje']='al registrar un tipo producto';

			if($lobjTipoProducto->registrar_tipo_producto())
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
			header('location:../vista/?modulo=producto/tipo_producto');
		break;
		case 'registrar_tipo_producto_ajax':
			if($lobjTipoProducto->registrar_tipo_producto())
			{
				echo '1';
			}
			else
			{
				echo '0';
			}
		break;
		case 'consultar_tipo_producto':
			if($latipo_productos=$lobjTipoProducto->consultar_tipo_productos())
			{
				$option='<option value=""></option>';
				for($i=0;$i<count($latipo_productos);$i++)
				{
					$option.='<option value="'.$latipo_productos[$i]['idtipo_producto'].'">'.$latipo_productos[$i]['descripciontip'].'</option>';
				}	
			}
			else
			{
				$option='<option>No se han encontrado registros</option>';
			}
			echo $option;
		break;
		case 'editar_tipo_producto':
			$_SESSION['mensaje']='al editar el tipo de producto';
			if($lobjTipoProducto->editar_tipo_producto())
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
			header('location:../vista/?modulo=producto/tipo_producto');
		break;
		case 'eliminar_tipo_producto':
			$_SESSION['mensaje']='al desactivar el tipo de producto';
			if($lobjTipoProducto->eliminar_tipo_producto())
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
			header('location:../vista/?modulo=producto/tipo_producto');
		break;
		case 'restaurar_tipo_producto':
			$_SESSION['mensaje']='al restaurar el tipo de producto';
			if($lobjTipoProducto->restaurar_tipo_producto())
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

			header('location:../vista/?modulo=producto/tipo_producto');
		break;
		default:
			header('location:../vista/?modulo=producto/tipo_producto');
		break;
	}

?>