<?php
	session_start();
	require_once("../clases/clase_cliente.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjCliente=new clsCliente;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjCliente->set_Cliente($_POST['idcliente']);
	$lobjCliente->set_Codigo($_POST['idcodigocli']);
	$lobjCliente->set_Rif($_POST['rifcli']);
	$lobjCliente->set_Nombre($_POST['razonsocial']);
	$lobjCliente->set_Direccion($_POST['direccioncli']);
	$lobjCliente->set_Correo($_POST['correounocli'], $_POST['correodoscli'], $_POST['correotrescli']);
	$lobjCliente->set_Telefono($_POST['telefonounocli'], $_POST['telefonodoscli'], $_POST['telefonotrescli']);
	$lobjCliente->set_Observacion($_POST['observacioncli']);
	$lobjCliente->set_Estatus($_POST['estatuscli']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_cliente':
			$_SESSION['mensaje']='al registrar un cliente';

			if($lobjCliente->registrar_cliente())
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
			header('location:../vista/?modulo=cliente/cliente');
		break;
		case 'consultar_cliente':
			if($laclientes=$lobjCliente->consultar_clientes())
			{
				$option='<option value=""></option>';
				for($i=0;$i<count($laclientes);$i++)
				{
					$option.='<option value="'.$laclientes[$i]['idcliente'].'">'.$laclientes[$i]['nombrecli'].'</option>';
				}	
			}
			else
			{
				$option='<option>No se han encontrado registros</option>';
			}
			echo $option;
		break;
		case 'editar_cliente':
			$_SESSION['mensaje']='al editar el cliente';
			if($lobjCliente->editar_cliente())
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
			header('location:../vista/?modulo=cliente/cliente');
		break;
		case 'eliminar_cliente':
			$_SESSION['mensaje']='al desactivar el cliente';
			if($lobjCliente->eliminar_cliente())
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
			header('location:../vista/?modulo=cliente/cliente');
		break;
		case 'restaurar_cliente':
			$_SESSION['mensaje']='al restaurar el cliente';
			if($lobjCliente->restaurar_cliente())
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

			header('location:../vista/?modulo=cliente/cliente');
		break;
		case 'buscar_cliente':
			$criterio_busqueda = htmlentities($_POST['criterio']);
			if($listado_clientes=$lobjCliente->consultar_clientes_like($criterio_busqueda))
			{
				print($listado_clientes);
			}
			else
			{
				print('<a>No se han encontrado clientes con esa descripción...</a>');
			}
		break;
		default:
			header('location:../vista/?modulo=cliente/cliente');
		break;
	}

?>