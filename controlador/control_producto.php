<?php
	session_start();
	require_once("../clases/clase_producto.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjProducto=new clsProducto;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjProducto->set_Producto($_POST['idproducto']);
	$lobjProducto->set_Codigo($_POST['idcodigo']);
	$lobjProducto->set_Descripcioncorta($_POST['descripcioncortapro']);
	$lobjProducto->set_Descripcionlarga($_POST['descripcionlargapro']);
	$lobjProducto->set_UnidadMedida($_POST['unidadmedidapro']);
	$lobjProducto->set_PrecioUnitario($_POST['preciounitariopro']);
	$lobjProducto->set_Existencia($_POST['existenciapro']);
	$lobjProducto->set_IdTipoProducto($_POST['ttipo_producto_idtipo_producto']);
	$lobjProducto->set_Observacion($_POST['observacionpro']);
	$lobjProducto->set_Estatus($_POST['estatuspro']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_producto':
			$_SESSION['mensaje']='al registrar un producto';

			if($lobjProducto->registrar_producto())
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
			header('location:../vista/?modulo=producto/producto');
		break;
		case 'editar_producto':
			$_SESSION['mensaje']='al editar el producto';
			if($lobjProducto->editar_producto())
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
			header('location:../vista/?modulo=producto/producto');
		break;
		case 'eliminar_producto':
			$_SESSION['mensaje']='al desactivar el producto';
			if($lobjProducto->eliminar_producto())
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
			header('location:../vista/?modulo=producto/producto');
		break;
		case 'restaurar_producto':
			$_SESSION['mensaje']='al restaurar el producto';
			if($lobjProducto->restaurar_producto())
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

			header('location:../vista/?modulo=producto/producto');
		break;
		default:
			header('location:../vista/?modulo=producto/producto');
		break;
	}

?>