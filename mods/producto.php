<?php
$vista = $ObjSistema->CapturarVista();
require_once('../clases/clase_producto.php');
require_once('../clases/clase_tipo_producto.php');
$lobjProducto = new clsProducto;
$lobjTipoProducto = new clsTipoProducto;

switch ($vista) {
        case 'producto':
                $laproductos = $lobjProducto->consultar_productos();
                $ObjSistema->consultar_opciones('?modulo=producto/consultar_producto', $opciones['btn_consultar'], '?modulo=producto/registrar_producto', $opciones['btn_registrar'], '?modulo=producto/eliminar_producto', $opciones['btn_eliminar'], '?modulo=producto/eliminar_producto', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);

                $HTML = $ObjSistema->get_cuerpo('Producto,Productos','#,?modulo=producto/producto','producto','producto');

                $ObjSistema->set_cuerpo($HTML);
                $diccionario =array('cuerpo' => file_exists("producto/template_productos.html") ? file_get_contents("producto/template_productos.html") : '');
        		$HTML = $ObjSistema->render($diccionario);
                
                $ObjSistema->set_cuerpo($HTML);
                if($laproductos)
                	$HTML = $ObjSistema->render_regex('LISTADO_PRODUCTOS', $laproductos);
                else
                	$HTML = $ObjSistema->reemplazar_vacio('LISTADO_PRODUCTOS', '');

                $ObjSistema->set_cuerpo($HTML);
                $HTML = $ObjSistema->render($opciones);
        break;
        case 'tipo_producto':
        $latipo_productos = $lobjTipoProducto->consultar_tipo_productos();
        $ObjSistema->consultar_opciones('?modulo=producto/consultar_tipo_producto', $opciones['btn_consultar'], '?modulo=producto/registrar_tipo_producto', $opciones['btn_registrar'], '?modulo=producto/eliminar_tipo_producto', $opciones['btn_eliminar'], '?modulo=producto/eliminar_tipo_producto', $opciones['btn_restaurar'],$opciones['operaciones'],$opciones['informacion']);

        $HTML = $ObjSistema->get_cuerpo('Producto,Tipo de Productos','#,?modulo=producto/tipo_producto','tipo_producto','producto');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("producto/template_tipo_productos.html") ? file_get_contents("producto/template_tipo_productos.html") : '');
        $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);
        if($latipo_productos)
            $HTML = $ObjSistema->render_regex('LISTADO_TIPO_PRODUCTOS', $latipo_productos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_TIPO_PRODUCTOS', '');

        $ObjSistema->set_cuerpo($HTML);
        $HTML = $ObjSistema->render($opciones);
        break;
         case 'registrar_tipo_producto':

        $HTML = $ObjSistema->get_cuerpo('producto,Tipo de Productos,Registrar Tipo de producto','#,?modulo=producto/tipo_producto,#','tipo_producto','producto');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("producto/registrar_tipo_producto.html") ? file_get_contents("producto/registrar_tipo_producto.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);

       
        break;
        case 'registrar_producto':
        $latipo_productos = $lobjTipoProducto->consultar_tipo_productos();

        $HTML = $ObjSistema->get_cuerpo('producto,Productos,Registrar producto','#,?modulo=producto/producto,#','producto','producto');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("producto/registrar_producto.html") ? file_get_contents("producto/registrar_producto.html") : '');
                $HTML = $ObjSistema->render($diccionario);
        
        $ObjSistema->set_cuerpo($HTML);

        if($latipo_productos)
            $HTML = $ObjSistema->render_regex('LISTADO_TIPO_PRODUCTO', $latipo_productos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_TIPO_PRODUCTO', '');
        $ObjSistema->set_cuerpo($HTML);
      
        break;
        case 'consultar_tipo_producto':
        $lobjTipoProducto->set_TipoProducto($id);
        $latipo_producto = $lobjTipoProducto->consultar_tipo_producto();

        $HTML = $ObjSistema->get_cuerpo('producto,Tipo de Productos,Consultar Tipo de producto','#,?modulo=producto/tipo_producto,#','tipo_producto','producto');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("producto/consultar_tipo_producto.html") ? file_get_contents("producto/consultar_tipo_producto.html") : '');
        $HTML = $ObjSistema->render($diccionario);        
        $ObjSistema->set_cuerpo($HTML);
        
        $HTML = $ObjSistema->render($latipo_producto);   
        $ObjSistema->set_cuerpo($HTML);
             

        break;
        case 'consultar_producto':
        $lobjProducto->set_Producto($id);
        $laproducto= $lobjProducto->consultar_producto();
        $lobjTipoProducto->set_TipoProducto($laproducto['ttipo_producto_idtipo_producto']);
        $latipo_productos = $lobjTipoProducto->consultar_tipo_productos_producto();

        $HTML = $ObjSistema->get_cuerpo('producto,Productos,Consultar producto','#,?modulo=producto/producto,#','producto','producto');

        $ObjSistema->set_cuerpo($HTML);
        $diccionario =array('cuerpo' => file_exists("producto/consultar_producto.html") ? file_get_contents("producto/consultar_producto.html") : '');
        $HTML = $ObjSistema->render($diccionario);        
        $ObjSistema->set_cuerpo($HTML);
        
        $HTML = $ObjSistema->render($laproducto);   
        $ObjSistema->set_cuerpo($HTML);
             
        if($latipo_productos)
            $HTML = $ObjSistema->render_regex('LISTADO_TIPO_PRODUCTO', $latipo_productos);
        else
            $HTML = $ObjSistema->reemplazar_vacio('LISTADO_TIPO_PRODUCTO', '');

        $ObjSistema->set_cuerpo($HTML);

        break;
	    default:
		header("location: ./");
		break;
}

?>
