<?php
	session_start();
	require_once("../clases/clase_chofer.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
    require_once('../libreria/UUID.php');
	$lobjChofer=new clsChofer;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;
	$lobjUUID=new UUID;

	$lobjChofer->set_Chofer($_POST['idchofer']);
	$lobjChofer->set_Codigo($_POST['idcodigocho']);
	$lobjChofer->set_Alias($_POST['aliascho']);
	$lobjChofer->set_Nombre($_POST['nombrecho']);
	$lobjChofer->set_Apellido($_POST['apellidocho']);
	$lobjChofer->set_CedulaRif($_POST['cedula_rifcho']);
	$lobjChofer->set_FechaNacimiento($_POST['fechanacimientocho']);
	$lobjChofer->set_Direccion($_POST['direccioncho']);
	$lobjChofer->set_Correo($_POST['correocho']);
	$lobjChofer->set_TelefonoMovil($_POST['telefonomovilcho']);
	$lobjChofer->set_TelefonoLocal($_POST['telefonolocalcho']);
	$lobjChofer->set_Observacion($_POST['observacioncho']);
	$lobjChofer->set_Estatus($_POST['estatuscho']);

	$lobjChofer->set_Documento($_POST['iddocumento']);
	$lobjChofer->set_FechaEmision($_POST['fechaemisiondoc']);
	$lobjChofer->set_FechaVencimiento($_POST['fechavencimientodoc']);
	$lobjChofer->set_Directorio($_POST['directoriodoc']);

	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	$iddocumento=$_POST['iddocumento'];
	$directoriodoc=$_FILES['directoriodoc'];
	$directoriodoc_post=$_POST['directorio_o'];
	$destino = '../media/img/documentos_chofer'; 
	$copiado=true;

	switch ($operacion) 
	{
		case 'registrar_chofer':
			$_SESSION['mensaje']='al registrar un tipo chofer';
			
			for($i=0;$i<count($iddocumento);$i++)
			{
				$tamano = $directoriodoc['size'][$i];
				$type=$directoriodoc['type'][$i];
 
				$piesas=explode("/",$type);
				$final=explode("e",$piesas[1]);			

				$directoriodoc_post[$i]=$_POST['cedula_rifcho']."_".$iddocumento[$i]."_".$lobjUUID->v4().".".$final[0].$final[1];
				if(($tamano <= 2000000)and($type=='image/jpeg')) 
 					if(!$copiado=copy($directoriodoc['tmp_name'][$i], $destino.'/'.$directoriodoc_post[$i]))
 						break;

 			}
 			if($copiado)
 			{
				$lobjChofer->set_Directorio($directoriodoc_post);

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
			for($i=0;$i<count($iddocumento);$i++)
			{
				$tamano = $directoriodoc['size'][$i];
				$type=$directoriodoc['type'][$i];
 
				$piesas=explode("/",$type);
				$final=explode("e",$piesas[1]);			
				
				if($directoriodoc['tmp_name'][$i])
				{
					$directoriodoc_post[$i]=$_POST['cedula_rifcho']."_".$iddocumento[$i]."_".$lobjUUID->v4().".".$final[0].$final[1];
					if(($tamano <= 2000000)and($type=='image/jpeg')) 
	 					if(!$copiado=copy($directoriodoc['tmp_name'][$i], $destino.'/'.$directoriodoc_post[$i]))
	 						break;
 				}


 			}
 			if($copiado)
 			{
 				$lobjChofer->set_Directorio($directoriodoc_post);
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
		case 'validar_codigo':
			if($lobjChofer->validar_codigo())
				echo '1'
			else
				echo '0'
		break;
		default:
			header('location:../vista/?modulo=chofer/chofer');
		break;
	}

?>