<?php
	session_start();
	require_once("../libreria/fpdf/fpdf.php");
	
	class clsFpdf extends FPDF
	{
		
		function set_orientacion($orientacion='p')
		{
			$this->FPDF($orientacion);
		}

		public function Header()
		{
			$this->SetY(50);
			
			
			//Salto de línea
		}

		//Pie de página
		public function Footer()
		{
			//Posición: a 2 cm del final
			$this->SetY(-20);
			//Arial italic 8
			$this->SetFont("Arial","I",6);
			//Dirección
			$this->Cell(0,4,utf8_decode("Fecha de impresión ".date('d-m-Y h:i a')." - Region Central COPIA COLOR: SIN DERECHO A CREDITO FISCAL"),0,1,"C");
			$this->Cell(0,4,"ESTA FORMA LIBRE VA SIN TACHADURAS NI ENMIENDADURA",0,1,"C");
			//Número de página
			$this->Cell(0,4,utf8_decode("Página ").$this->PageNo()."/{nb}",0,0,"C");
		}
	}
?>
