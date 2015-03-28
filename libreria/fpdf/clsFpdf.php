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
			$this->Image('../media/img/logo-black.jpg',10,10,100,15);
			$this->SetFont("Arial","",8);
			$this->Ln(16);

			$this->MultiCell(80,6,"Calle E, Zona Industrial San Vicente II, Edo. Aragua
Contacto: 0243-671-82-44 venasol@hotmail.com",0,"J");
			
			//Salto de línea
			$this->Ln();
		}

		//Pie de página
		public function Footer()
		{
			//Posición: a 2 cm del final
			$this->SetY(-20);
			//Arial italic 8
			$this->SetFont("Arial","I",8);
			//Dirección
			$this->Cell(0,7,utf8_decode("Fecha de impresión ".date('d-m-Y h:i a')." - Region Central COPIA COLOR: SIN DERECHO A CREDITO FISCAL"),0,1,"C");
			$this->Cell(0,7,"ESTA FORMA LIBRE VA SIN TACHADURAS NI ENMIENDADURA",0,1,"C");
			//Número de página
			$this->Cell(0,7,utf8_decode("Página ").$this->PageNo()."/{nb}",0,0,"C");
		}
	}
?>
