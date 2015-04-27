<?php
	session_start();
	require_once("../clases/clase_configuracion.php");
	require_once("../clases/clase_bitacora.php");
    require_once('../libreria/utilidades.php');
    require_once('../libreria/uuid.php');
	$lobjConfiguracion=new clsConfiguracion;
	$lobjBitacora=new clsBitacora;
	$lobjUtil=new clsUtil;
	$lobjUUID=new UUID;

	
	$prefijo_chofer=$_POST['prefijo_chofer'];
	$prefijo_producto=$_POST['prefijo_producto'];

	$lobjConfiguracion->set_prefijo_chofer($prefijo_chofer);
	$lobjConfiguracion->set_prefijo_producto($prefijo_producto);
	
	$lcReal_ip=$lobjUtil->get_real_ip();
    $ldFecha=date('Y-m-d h:m');
	$operacion=$_POST['operacion'];

	switch ($operacion) 
	{
		case 'configuracion':
			$imagenlogo=$_FILES['imagenlogo'];
			$imagenreporte=$_FILES['imagenreporte'];
			$imagenlogo_oscuro=$_FILES['imagenlogo_oscuro'];
			$imagenshort_icon=$_FILES['imagenshort_icon'];				

			$destino = '../media/img/';
			$copiado=true;
			$_SESSION['mensaje']='al subir archivos';


			if($imagenlogo['tmp_name'])
			{
				$type= explode(".",$imagenlogo['name']);
				$extension = end($type);
				$_POST['imagenlogo_o']=$type[0]."_".$lobjUUID->v4().".".$extension;
				$copiado=copy($imagenlogo['tmp_name'], $destino.'/'.$_POST['imagenlogo_o']);
			}

			if($imagenreporte['tmp_name'])
			{
				$type= explode(".",$imagenreporte['name']);
				$extension = end($type);
				$_POST['imagenreporte_o']=$type[0]."_".$lobjUUID->v4().".".$extension;
				$copiado=copy($imagenreporte['tmp_name'], $destino.'/'.$_POST['imagenreporte_o']);
			}

			if($imagenlogo_oscuro['tmp_name'])
			{
				$type= explode(".",$imagenlogo_oscuro['name']);
				$extension = end($type);
				$_POST['imagenlogo_oscuro_o']=$type[0]."_".$lobjUUID->v4().".".$extension;
				$copiado=copy($imagenlogo_oscuro['tmp_name'], $destino.'/'.$_POST['imagenlogo_oscuro_o']);
			}

			if($imagenshort_icon['tmp_name'])
			{
				$type= explode(".",$imagenshort_icon['name']);
				$extension = end($type);
				$_POST['imagenshort_icon_o']=$type[0]."_".$lobjUUID->v4().".".$extension;
				$copiado=copy($imagenshort_icon['tmp_name'], $destino.'/'.$_POST['imagenshort_icon_o']);
			}
 			if($copiado)
 			{
 				$lobjConfiguracion->set_ImagenLogo($_POST['imagenlogo_o']);
				$lobjConfiguracion->set_ImagenReporte($_POST['imagenreporte_o']);
				$lobjConfiguracion->set_ImagenLogo_Oscuro($_POST['imagenlogo_oscuro_o']);
				$lobjConfiguracion->set_ImagenShort_Icon($_POST['imagenshort_icon_o']);

				$_SESSION['mensaje']='al guardar la configuración';
				if($lobjConfiguracion->guardar_configuracion())
				{

					$_SESSION['imagenlogo']=$_POST['imagenlogo_o'];
					$_SESSION['imagenreporte']=$_POST['imagenreporte_o'];
					$_SESSION['imagenlogo_oscuro']=$_POST['imagenlogo_oscuro_o'];
					$_SESSION['imagenshort_icon']=$_POST['imagenshort_icon_o'];
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
			header('location:../vista/?modulo=configuracion/configuracion');
		break;
		default:
			header('location:../vista/?modulo=configuracion/configuracion');
		break;
	}

?>