<?php
	session_start();
	require_once("../clases/clase_documento.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
	$lobjDocumento=new clsDocumento;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;

	$lobjDocumento->set_Documento($_POST['iddocumento']);
	$lobjDocumento->set_Descripcion($_POST['descripciondoc']);
	$lobjDocumento->set_Vence($_POST['vencedoc']);
	$lobjDocumento->set_Duracion($_POST['duraciondoc']);
	$lobjDocumento->set_Observacion($_POST['observaciondoc']);
	$lobjDocumento->set_Estatus($_POST['estatusdoc']);
	$lobjDocumento->set_Chofer($_POST['idchofer']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'registrar_documento':
			$_SESSION['mensaje']='al registrar un documento';

			if($lobjDocumento->registrar_documento())
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
			header('location:../vista/?modulo=chofer/documento');
		break;
		case 'consultar_documento':
			if($ladocumentos=$lobjDocumento->consultar_documentos())
			{
				$option='<option value=""></option>';
				for($i=0;$i<count($ladocumentos);$i++)
				{
					$option.='<option value="'.$ladocumentos[$i]['iddocumento'].'" data-vence="'.$ladocumentos[$i]['vencedoc'].'">'.$ladocumentos[$i]['descripciondoc'].'</option>';
				}	
			}
			else
			{
				$option='<option>No se han encontrado registros</option>';
			}
			echo $option;
		break;
		case 'editar_documento':
			$_SESSION['mensaje']='al editar el documento';
			if($lobjDocumento->editar_documento())
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
			header('location:../vista/?modulo=chofer/documento');
		break;
		case 'eliminar_documento':
			$_SESSION['mensaje']='al desactivar el documento';
			if($lobjDocumento->eliminar_documento())
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
			header('location:../vista/?modulo=chofer/documento');
		break;
		case 'restaurar_documento':
			$_SESSION['mensaje']='al restaurar el documento';
			if($lobjDocumento->restaurar_documento())
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

			header('location:../vista/?modulo=chofer/documento');
		break;
		default:
			header('location:../vista/?modulo=chofer/documento');
		break;
	}

?>