<?php
	session_start();
	require_once("../clases/clase_modelo.php");
	require_once("../clases/clase_marca.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjModelo=new clsModelo;
	$lobjMarca=new clsMarca;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjMarca->set_Descripcion($_POST['descripcionmar']);
	$lobjMarca->set_Marca($_POST['idmarca']);
	$lobjMarca->set_Observacion($_POST['observacionmar']);
	$lobjMarca->set_Estatus($_POST['estatusmar']);

	$lobjModelo->set_Modelo($_POST['idmodelo']);
	$lobjModelo->set_Descripcion($_POST['descripcionmod']);
	$lobjModelo->set_Marca($_POST['idmarca']);
	$lobjModelo->set_Observacion($_POST['observacionmod']);
	$lobjModelo->set_Estatus($_POST['estatusmod']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_marca':
			$_SESSION['mensaje']='al registrar una marca';

			if($lobjMarca->registrar_marca())
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
			header('location:../vista/?modulo=vehiculo/marca');
		break;
		case 'consultar_marca':
			if($lamarcas=$lobjMarca->consultar_marcas())
			{
				$option='<option value=""></option>';
				for($i=0;$i<count($lamarcas);$i++)
				{
					$option.='<option value="'.$lamarcas[$i]['idmarca'].'">'.$lamarcas[$i]['descripcionmar'].'</option>';
				}	
			}
			else
			{
				$option='<option>No se han encontrado registros</option>';
			}
			echo $option;
		break;
		case 'editar_marca':
			$_SESSION['mensaje']='al editar la marca';
			if($lobjMarca->editar_marca())
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
			header('location:../vista/?modulo=vehiculo/marca');
		break;
		case 'eliminar_marca':
			$_SESSION['mensaje']='al desactivar la marca';
			if($lobjMarca->eliminar_marca())
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
			header('location:../vista/?modulo=vehiculo/marca');
		break;
		case 'restaurar_marca':
			$_SESSION['mensaje']='al restaurar la marca';
			if($lobjMarca->restaurar_marca())
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

			header('location:../vista/?modulo=vehiculo/marca');
		break;
		case 'consultar_modelos':
			require_once("../clases/clase_sistema.php");
			$lobjSistema = new clsGlobal();
			$lamodelos = $lobjModelo->consultar_modelos_marca();
			$contenido = file_get_contents('../vista/vehiculo/template_modelos.html');
			$lobjSistema->set_cuerpo($contenido);
			if($lamodelos)
				$HTML = $lobjSistema->render_regex('LISTADO_MODELOS', $lamodelos);
			else
            	$HTML = $lobjSistema->reemplazar_vacio('LISTADO_MODELOS', '<td colspan="5">No existen modelos registrados</td>');


			print($HTML);
		break;
		case 'registrar_modelo':
			$_SESSION['mensaje']='al registrar un modelo';

			if($lobjModelo->registrar_modelo())
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
			header('location:'.$_SERVER['HTTP_REFERER']);
		break;
		case 'eliminar_modelo':
			$_SESSION['mensaje']='al desactivar el modelo';
			if($lobjModelo->eliminar_modelo())
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
			header('location:'.$_SERVER['HTTP_REFERER']);
		break;
		case 'restaurar_modelo':
			$_SESSION['mensaje']='al restaurar el modelo';
			if($lobjModelo->restaurar_modelo())
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

			header('location:'.$_SERVER['HTTP_REFERER']);
		break;
		case 'editar_modelo':
			$_SESSION['mensaje']='al editar el modelo';
			if($lobjModelo->editar_modelo())
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
			header('location:'.$_SERVER['HTTP_REFERER']);
		break;
		default:
			header('location:../vista/?modulo=vehiculo/marca');
		break;
	}

?>