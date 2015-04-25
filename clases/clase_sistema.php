<?php
	require_once('clase_configuracion.php');
	class clsGlobal extends clsConfiguracion
	{
		private $str;

		public function get_cuerpo($vista,$enlace,$servicio,$modulo)
		{
		    $template_html = file_get_contents('template_base.html');
		    $this->str = $template_html;
		    $vista=$this->armarDiccionario($vista,$enlace);
		    $mensaje=$this->armarMensaje();
		    $dividir_parametros = explode(' ', $_SESSION['nombreusu']);
			$Diccionario	=array(	'Servicio'=> array('servicio'=>$servicio,'modulo'=>$modulo),
									'Mensaje'=>$mensaje,
									'Menu'=>$this->get_menu(),
									'Imagen'=>array('imagenlogo'=>$_SESSION['imagenlogo'],'imagenlogo_oscuro'=>$_SESSION['imagenlogo_oscuro'],'imagenshort_icon'=>$_SESSION['imagenshort_icon']),
									'nombreusu'=>array('nombre_corto'=> $dividir_parametros[0], 'nombre_largo'=>$_SESSION['nombreusu'])
									);

        	$this->set_cuerpo($this->render($Diccionario['Servicio']));
        	$this->set_cuerpo($this->render($Diccionario['Mensaje']));
        	$this->set_cuerpo($this->render($Diccionario['Menu']));
        	$this->set_cuerpo($this->render($Diccionario['nombreusu']));
        	$this->set_cuerpo($this->render($Diccionario['Imagen']));
        	if($vista)
        		return $this->render_regex('LISTADO_VISTA',$vista);
        	else
        		return $this->reemplazar_vacio('LISTADO_VISTA','');
		}


		public function CapturarModulo() 
		{
			$lcModulo = '';
			if(isset($_GET)) 
			{
				if(array_key_exists('modulo', $_GET))
				{
					$lcModulo = $_GET['modulo'];
					$division_parametros = explode('/', $lcModulo);
					$lcModulo = $division_parametros[0];
				}
			}
			return $lcModulo;
		}

		public function CapturarVista() 
		{
			$lcModulo = '';
			if(isset($_GET)) 
			{
				if(array_key_exists('modulo', $_GET))
				{
					$lcModulo = $_GET['modulo'];
					$division_parametros = explode('/', $lcModulo);
					$lcModulo = $division_parametros[1];
				}
			}
			return $lcModulo;
		}

		public function CapturarId() 
		{
			$id = '';
			if($_GET) 
			{
				if(array_key_exists('id', $_GET))
				{
					$id = $_GET['id'];
				}
			}
			return $id;
		}

		private function armarDiccionario($vista,$enlace)
		{
			if($vista!='')
			{
				$vistas=split(',',$vista);
				$enlaces=split(',',$enlace);
				$i=0;
				unset($vista);
				for($i=0;$i<count($vistas);$i++) {
					$vista[$i]['vista']=$vistas[$i];
					$vista[$i]['enlace']=$enlaces[$i];
				}
			}
			return $vista;
		}

		private function armarMensaje()
		{
			$visible=($_SESSION['mensaje'])?'fade in':'hide';
			$Mensaje =array('visible'=>$visible,'resultado_color'=>$_SESSION['resultado_color'],'icono_mensaje'=>$_SESSION['icono_mensaje'],'resultado'=>$_SESSION['resultado'],'mensaje'=>$_SESSION['mensaje']);
			unset($_SESSION['resultado_color']);
			unset($_SESSION['icono_mensaje']);
			unset($_SESSION['resultado']);
			unset($_SESSION['mensaje']);

			return $Mensaje;
		}

		private function get_menu()
		{
			require_once('../clases/clase_rol.php');
        	$lobjrol = new clsrol;
        	$lobjrol->set_Rol($_SESSION['idrol']);
        	$modulos = $lobjrol->consultar_modulos_menu();
        	$activo_home = false;
        	$servicio_activo = false;
        	$activar_home = '';
        	for($i=0; $i < count($modulos); $i++)
        	{
        		$open = ($this->CapturarModulo() == $modulos[$i]['case']) ? 'class="active"' : '';
        		$activo_home = (($this->CapturarModulo() == $modulos[$i]['case']) && ($activo_home==false)) ? true : false;
        		$MENU .= '<li '.$open.'>';
        		$icono = ($modulos[$i]['icono']) ? $modulos[$i]['icono'] : 'folder';
        		$nombre = $modulos[$i]['nombremod'];
        		$servicios = $lobjrol->consultar_servicios_menu($modulos[$i]['idmodulo']);
        		$right = (count($servicios) > 0) ? 'fa fa-angle-right' : '';
        		$MENU.='<a href="#" class="dropdown-toggle">
							<i class="fa fa-'.$icono.'"></i>
							<span>'.$nombre.'</span>
							<i class="'.$right.' drop-icon"></i>
						</a>';
				$MENU.= (count($servicios) > 0) ? '<ul class="submenu">':'';
        		for($j=0; $j < count($servicios); $j++)
        		{
        			$url = $servicios[$j]['enlaceser'];
        			$nombre_ser = $servicios[$j]['nombreser'];
        			$division_parametro_uri = explode('?', $_SERVER['REQUEST_URI']);
        			$division_parametro_url = explode('?', $url);
        			$active = ($division_parametro_uri[1] == $division_parametro_url[1]) ? 'class="active"' : '';
        			$servicio_activo = (($division_parametro_uri[1] == $division_parametro_url[1])  && ($servicio_activo==false))? true : false;
        			$MENU.='<li>
								<a '.$active.' href="'.$url.'">
								'.$nombre_ser.'
								</a>
							</li>';
        		}
				$MENU.= (count($servicios) > 0) ? '</ul>':'';
        		$MENU .= '</li>';
        	}
        	if(($activo_home)||(!$servicio_activo))
        	  	$activar_home = 'class="active"';
			return array('menu'=>$MENU, 'active_home'=>$activar_home);
		}

		public function set_cuerpo($str='') {
        	$this->str = $str; //Archivo que le envio del file_get
        	//$this->filename = STATIC_DIR . "html/template.html"; Directorio estatico
   		}

    	public function render($dict=array()) {
	        settype($dict, 'array');
	        $this->set_dict($dict);
	        return str_replace(array_keys($this->dict), array_values($this->dict),
	            $this->str);
	    }

	    function sin_datos($key, $msg, $remove_keys=True) {
	        $regex = "/<!--$key-->(.|\n){1,}<!--$key-->/";
	        preg_match($regex, $this->str, $matches);
	        $no_keys = str_replace("<!--$key-->", "", $matches[0]);
	        return ($remove_keys) ? $no_keys : $matches[0];
	    }

		function render_regex($key='REGEX', $stack=array(), $use_pcre=False) { //Funcion que organiza todo el peo de la lista
	        $originalstr = $this->str;
	        $func = ($use_pcre) ? "get_regex" : "get_substr";
	        $match = $this->$func($key, False);
	        $this->str = $this->$func($key);
	        $render = '';
	        foreach($stack as $dict) $render .= $this->render($dict);
	        return str_replace($match, $render, $originalstr);
	    }

	    public function show($contenido='') {
	        $tmpl = file_get_contents($this->filename);
	        $dict = array("TITLE"=>$this->str, "CONTENIDO"=>$contenido);
	        return Template($tmpl)->render($dict);
	    }

	    function get_regex($key, $remove_keys=True) {
	        $regex = "/<!--$key-->(.|\n){1,}<!--$key-->/";
	        preg_match($regex, $this->str, $matches);
	        $no_keys = str_replace("<!--$key-->", "", $matches[0]);
	        return ($remove_keys) ? $no_keys : $matches[0];
	    }
 
	    function get_substr($key, $remove_keys=True) {
	        $needle = "<!--$key-->";  //Key consigue el nombre de la lista
	        $first = strpos($this->str, $needle);  //Que hay de primero
	        $last = strrpos($this->str, $needle);	//Que hay de ultimo
	        $long = ($last - $first) + strlen($needle);  //Longitud de como va creciendo el KEY
	        $str = substr($this->str, $first, $long);  //emplaza el string
	        $no_keys = str_replace($needle, "", $str);
	        return ($remove_keys) ? $no_keys : $str;
	    }

	    function reemplazar_vacio($key='REGEX', $msg) { //Funcion que organiza todo el peo de la lista
	       $HTML = $this->get_substr($key, False);
	        return str_replace($HTML, $msg, $this->str);
	    }


	    function render_substr($key='REGEX', $stack=array()) {
	        return $this->render_regex($key, $stack, False);
	    }
 
	    protected function set_dict($dict=array()) {
	        $this->sanitize($dict);
	        $keys = array_keys($dict);
	        $values = array_values($dict);
	        foreach($keys as &$key) {
	            $key = "{{$key}}";
	        }
	        $this->dict = array_combine($keys, $values);
	    }
   
	    private function sanitize(&$dict) {
	        foreach($dict as $key=>&$value) {
	            if(is_array($value) or is_object($value)) {
	                $value = print_r($value, True);
	                if(strlen($value) > 100) {
	                    $value = substr($value, 0, 100) . chr(10) . "(...)";
	                    $value = nl2br($value);
	                }
	            }
	        }
	    }

	    public function consultar_opciones($vista1='', &$opcion1='', $vista2='', &$opcion2='', $vista3='', &$opcion3='',
	    		 							$vista4='', &$opcion4='',&$operaciones='',&$informacion='')
	    {
	    	require_once('../clases/clase_rol.php');
        	$lobjrol = new clsrol;
        	$lobjrol->set_Rol($_SESSION['idrol']);
        	$laModulos = $lobjrol->consultar_modulos();
	    	$opcion1= $opcion2= $opcion3= $opcion4= $operaciones=$informacion='hide';
			for($i=0;$i<count($laModulos);$i++) 
		    {
		        $laServicios=$lobjrol->consultar_servicios_menu($laModulos[$i]['idmodulo'], ''); 
		        for ($j=0; $j <count($laServicios) ; $j++) //Se recorre un ciclo para poder extraer los datos de cada uno de los servicios que tiene asignado el modulo para poder constuir el menú
		        {
		            if($laServicios[$j]['enlaceser']==$vista1)
		            {
		                $opcion1=$operaciones=$informacion='';
		            }
		            if($laServicios[$j]['enlaceser']==$vista2)
		            {
		                $opcion2=$informacion='';
		            }
		            if($laServicios[$j]['enlaceser']==$vista3)
		            {
		                $opcion3=$operaciones=$informacion='';
		            }
		            if($laServicios[$j]['enlaceser']==$vista4)
		            {
		                $opcion4=$operaciones=$informacion='';
		            }
		        }
		    }
	    }
	}
?>