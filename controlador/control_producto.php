<?php
	session_start();
	require_once("../clases/clase_producto.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
    require_once('../libreria/UUID.php');
	$lobjProducto=new clsProducto;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;
	$lobjUUID=new UUID;

	$lobjProducto->set_Producto($_POST['idproducto']);
	$lobjProducto->set_Codigo($_POST['idcodigo']);
	$lobjProducto->set_Descripcioncorta($_POST['descripcioncortapro']);
	$lobjProducto->set_Descripcionlarga($_POST['descripcionlargapro']);
	$lobjProducto->set_UnidadMedida($_POST['unidadmedidapro']);
	$lobjProducto->set_PrecioUnitario($_POST['preciounitariopro']);
	$lobjProducto->set_PrecioCompra($_POST['preciocomprapro']);
	$lobjProducto->set_Existencia($_POST['existenciapro']);
	$lobjProducto->set_IdTipoProducto($_POST['ttipo_producto_idtipo_producto']);
	$lobjProducto->set_Observacion($_POST['observacionpro']);
	$lobjProducto->set_Estatus($_POST['estatuspro']);

	$lobjProducto->set_Documento($_POST['iddocumento']);
	$lobjProducto->set_FechaEmision($_POST['fechaemisiondoc']);
	$lobjProducto->set_FechaVencimiento($_POST['fechavencimientodoc']);
	$lobjProducto->set_Directorio($_POST['directoriodoc']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	$iddocumento=$_POST['iddocumento'];
	$directoriodoc=$_FILES['directoriodoc'];
	$directoriodoc_post=$_POST['directorio_o'];
	$destino = '../media/img/documentos_producto'; 
	$copiado=true;

	switch ($operacion) 
	{
		case 'registrar_producto':
			$_SESSION['mensaje']='al registrar un producto';
			for($i=0;$i<count($iddocumento);$i++)
			{
				$nombre_archiv=$directoriodoc['name'][$i];
				$type= explode(".", $nombre_archiv);
				$extension = end($type);

				$directoriodoc_post[$i]=$_POST['descripcioncortapro']."_".$iddocumento[$i]."_".$lobjUUID->v4().".".$extension;
 				if(!$copiado=copy($directoriodoc['tmp_name'][$i], $destino.'/'.$directoriodoc_post[$i]))
 					break;

 			}
 			if($copiado)
 			{
				$lobjProducto->set_Directorio($directoriodoc_post);

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
			for($i=0;$i<count($iddocumento);$i++)
			{
				$nombre_archiv=$directoriodoc['name'][$i];
				$type= explode(".", $nombre_archiv);
				$extension = end($type);
 
				if($directoriodoc['tmp_name'][$i])
				{
					$directoriodoc_post[$i]=$_POST['descripcioncortapro']."_".$iddocumento[$i]."_".$lobjUUID->v4().".".$extension;
	 				if(!$copiado=copy($directoriodoc['tmp_name'][$i], $destino.'/'.$directoriodoc_post[$i]))
	 					break;
 				}

 			}
 			if($copiado)
 			{
 				$lobjProducto->set_Directorio($directoriodoc_post);
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
		case 'buscar_producto':
			$criterio_busqueda = htmlentities($_POST['criterio']);
			if($listado_productos=$lobjProducto->consultar_productos_like($criterio_busqueda))
			{
				print($listado_productos);
			}
			else
			{
				print('<a class="suggest-element">No se han encontrado clientes con esa descripción...</a>');
			}
		break;
		default:
			header('location:../vista/?modulo=producto/producto');
		break;
	}

?>