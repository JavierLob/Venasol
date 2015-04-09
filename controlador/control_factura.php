<?php
	#ini_set('error_reporting', E_ALL);
	session_start();
	require_once("../clases/clase_factura.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjFactura=new clsFactura;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_factura':
			$id_cliente 	= $_POST['idcliente'];
			$total_total 	= $_POST['total_total'];
			$iva 			= $_POST['iva'];
			$id_chofer 		= $_POST['chofer'];
			$id_vehiculo 	= $_POST['vehiculo'];
			$id_accesorio 	= $_POST['accesorio'];
			$precintos 		= $_POST['precintos'];
			$productos 		= $_POST['idproducto'];
			$precio_productos 		= $_POST['precio_producto'];
			$cantidad_productos 	= $_POST['cantidad_producto'];
			$total_productos		= $_POST['total_producto'];
			$observacion			= $_POST['observacion'];

			$errores = true;
			$idfactura = $lobjFactura->obtener_nro_factura();
			$lobjFactura->begin();

			$lobjFactura->set_Factura($idfactura['nro_factura']);
			$lobjFactura->set_Vehiculo($id_vehiculo);
			$lobjFactura->set_Accesorio($id_accesorio);
			$lobjFactura->set_Cliente($id_cliente);
			$lobjFactura->set_Chofer($id_chofer);
			$lobjFactura->set_Iva($iva);
			$lobjFactura->set_Total($total_total);
			$lobjFactura->set_Observacion($observacion);
			$lobjFactura->set_Estatus();

			$resp[] = $lobjFactura->registrar_factura();
			$cont = 0;
			foreach ($productos as $id_producto) {
				$cantidad = $cantidad_productos[$cont];
				$precio = $precio_productos[$cont];
				$resp[] = $lobjFactura->registrar_detalle_factura($id_producto, $cantidad, $precio);
				$cont++;
			}

			foreach ($precintos as $precinto) {
				$resp[] = $lobjFactura->asignar_precinto($precinto);
			}

			foreach ($resp as $value) {
				if(!$value)
					$errores = false;
			}

			if($errores)
			{
				$lobjFactura->commit();
				$mensaje = array('mensaje'=>'1', 'nro_factura'=>$idfactura['nro_factura']);
				print(json_encode($mensaje));
			}
			else
			{
				$lobjFactura->rollback();
				$mensaje = array('mensaje'=>'0');
				print(json_encode($mensaje));
			}
		break;
		case 'modificar_factura':
			$idfactura 	= $_POST['idfactura'];
			$id_cliente 	= $_POST['idcliente'];
			$total_total 	= $_POST['total_total'];
			$iva 			= $_POST['iva'];
			$id_chofer 		= $_POST['chofer'];
			$id_vehiculo 	= $_POST['vehiculo'];
			$id_accesorio 	= $_POST['accesorio'];
			$precintos 		= $_POST['precintos'];
			$productos 		= $_POST['idproducto'];
			$precio_productos 		= $_POST['precio_producto'];
			$cantidad_productos 	= $_POST['cantidad_producto'];
			$total_productos		= $_POST['total_producto'];
			$observacion			= $_POST['observacion'];

			$errores = true;
			$lobjFactura->set_Factura($idfactura);

			$lobjFactura->begin();

			$resp[] = $lobjFactura->desasignar_precinto();
			$resp[] = $lobjFactura->limpiar_detalle_factura();

			$lobjFactura->set_Vehiculo($id_vehiculo);
			$lobjFactura->set_Accesorio($id_accesorio);
			$lobjFactura->set_Cliente($id_cliente);
			$lobjFactura->set_Chofer($id_chofer);
			$lobjFactura->set_Iva($iva);
			$lobjFactura->set_Total($total_total);
			$lobjFactura->set_Observacion($observacion);
			$lobjFactura->set_Estatus();

			$resp[] = $lobjFactura->modificar_factura();
			$cont = 0;
			foreach ($productos as $id_producto) {
				$cantidad = $cantidad_productos[$cont];
				$precio = $precio_productos[$cont];
				$resp[] = $lobjFactura->registrar_detalle_factura($id_producto, $cantidad, $precio);
				$cont++;
			}

			foreach ($precintos as $precinto) {
				$resp[] = $lobjFactura->asignar_precinto($precinto);
			}

			foreach ($resp as $value) {
				if(!$value)
					$errores = false;
			}

			if($errores)
			{
				$lobjFactura->commit();
				$mensaje = array('mensaje'=>'1', 'nro_factura'=>$idfactura);
				print(json_encode($mensaje));
			}
			else
			{
				$lobjFactura->rollback();
				$mensaje = array('mensaje'=>'0');
				print(json_encode($mensaje));
			}
		break;
		default:
			header('location:../vista/?modulo=cliente/cliente');
		break;
	}

?>