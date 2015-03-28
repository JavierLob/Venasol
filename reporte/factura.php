<?php
date_default_timezone_set('America/Caracas');
ob_end_clean();
require_once("../libreria/fpdf/clsFpdf.php");
//require_once('../clases/clase_factura.php');

$lobjPdf=new clsFpdf();
//$lobjFactura=new clsFactura();
$lobjPdf->AliasNbPages();
$lobjPdf->AddPage("P","Letter");
$idfactura=(isset($_GET['id']))?$_GET['id']:'';
//$lobjFactura->set_Factura($idfactura);
//$laFactura=$lobjFactura->consultar_factura();

$lobjPdf->SetTextColor(50,50,50);

$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(0,6,utf8_decode("FORMA LIBRE"),0,1,"R");

$lobjPdf->SetFillColor(240,240,240);
$lobjPdf->SetFont("arial","B",6);

$lobjPdf->Cell(160,6,utf8_decode("DATOS DEL CLIENTE"),"B",0,"C",true);
$lobjPdf->Cell(40,6,utf8_decode("Nº DE CONTROL"),"B",1,"C",true);
$lobjPdf->SetFont("arial","B",6);

$lobjPdf->Cell(40,6,utf8_decode("Cliente: "),0,0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(120,6,utf8_decode($laFactura['razonsocialcli']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->SetTextColor(220,50,50);
$lobjPdf->Cell(40,6,utf8_decode("00000001"),"L",1,"C");
$lobjPdf->SetTextColor(50,50,50);
$lobjPdf->SetFont("arial","B",6);

$lobjPdf->Cell(40,6,utf8_decode("RIF: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(120,6,utf8_decode($laFactura['rifcli']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(40,6,utf8_decode("FECHA: "),"L",1,"C",true);

$lobjPdf->Cell(40,6,utf8_decode("Dirección: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(120,6,utf8_decode($laFactura['rifcli']),0,0,"L");
$lobjPdf->Cell(40,6,utf8_decode($laFactura['fechafac']),"L",1,"L");

$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(40,6,utf8_decode("DATOS CHOFER"),"B",0,"C",true);
$lobjPdf->Cell(80,6,utf8_decode("DATOS VEHÍCULO"),"B",0,"C",true);
$lobjPdf->Cell(80,6,utf8_decode("DATOS ACCESORIO"),"B",1,"C",true);

$lobjPdf->Cell(20,6,utf8_decode("Nombre: "),0,0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['nombrecho'].' '.$laFactura['apellidocho']),0,0,"L");

$lobjPdf->Cell(20,6,utf8_decode("Placa: "),"L",0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['placaveh']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(20,6,utf8_decode("Año: "),0,0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['anoveh']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);

$lobjPdf->Cell(20,6,utf8_decode("Placa: "),"L",0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['placaacc']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(20,6,utf8_decode("Año: "),0,0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['anoacc']),0,1,"L");
$lobjPdf->SetFont("arial","B",6);

$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(20,6,utf8_decode("C.I. : "),0,0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['cedula_rifcho']),0,0,"L");

$lobjPdf->Cell(20,6,utf8_decode("Color: "),"L",0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['colorveh']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(20,6,utf8_decode("Marca: "),0,0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['descripcionmar']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);



$lobjPdf->Cell(20,6,utf8_decode("Color: "),"L",0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['coloracc']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(20,6,utf8_decode("Marca: "),0,0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['descripcionmar']),0,1,"L");

$lobjPdf->SetX(50);
$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(20,6,utf8_decode("Modelo: "),"L",0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(60,6,utf8_decode($laFactura['descripcionmod']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);


$lobjPdf->Cell(20,6,utf8_decode("Modelo: "),"L",0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['descripcionmod']),0,0,"L");
$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(20,6,utf8_decode("Capacidad: "),0,0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['capacidadacc'].' '.$laFactura['unidadmedidaacc']),0,1,"L");

$lobjPdf->SetX(130);
$lobjPdf->SetFont("arial","B",6);
$lobjPdf->Cell(40,6,utf8_decode("Precintos: "),"L",0,"L");
$lobjPdf->SetFont("arial","",6);
$lobjPdf->MultiCell(60,6,utf8_decode($laFactura['codigopre']),0,"L");

$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(40,6,utf8_decode("CANTIDAD"),"B",0,"C",true);
$lobjPdf->Cell(80,6,utf8_decode("DESCRIPCIÓN"),"B",0,"C",true);
$lobjPdf->Cell(40,6,utf8_decode("PRECIO"),"B",0,"C",true);
$lobjPdf->Cell(40,6,utf8_decode("TOTAL"),"B",1,"C",true);

$lobjPdf->SetFont("arial","",8);
for($i=0;$i<3;$i++)
{
	$subTotal=$laFactura['cantidad'][$i]*$laFactura['precio'][$i];
	$Total=$Total+$subTotal;

	$lobjPdf->Cell(40,6,utf8_decode($laFactura['cantidad'][$i]),1,0,"C");
	$lobjPdf->Cell(80,6,utf8_decode($laFactura['descripcion'][$i]),1,0,"C");
	$lobjPdf->Cell(40,6,utf8_decode($laFactura['precio'][$i]),1,0,"C");
	$lobjPdf->Cell(40,6,utf8_decode($subTotal),1,1,"C");
}

$lobjPdf->SetX(130);
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(40,6,utf8_decode("SUB-TOTAL: "),1,0,"R",true);
$lobjPdf->SetFont("arial","",10);
$lobjPdf->Cell(40,6,utf8_decode($Total),1,1,"C");

$lobjPdf->SetX(130);
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(40,6,utf8_decode("IVA (12%): "),1,0,"R",true);
$lobjPdf->SetFont("arial","",10);
$lobjPdf->Cell(40,6,utf8_decode($Total*0.12),1,1,"C");
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->SetX(130);
$lobjPdf->Cell(40,6,utf8_decode("TOTAL: "),1,0,"R",true);
$lobjPdf->SetFont("arial","",10);
$lobjPdf->Cell(40,6,utf8_decode($Total*1.12),1,1,"C");

$lobjPdf->Ln(5);
$lobjPdf->SetTextColor(10,10,10);

$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(20,6,utf8_decode("NOTA: "),0,1,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->MultiCell(200,6,utf8_decode($laFactura['observacionfac']),1,"L");
$lobjPdf->Ln(15);

$lobjPdf->SetY(-65);
$lobjPdf->SetX(75);
$lobjPdf->Cell(70,35,utf8_decode(""),1,1,"C");
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->Cell(0,6,utf8_decode("SELLO"),0,1,"C");

$lobjPdf->Output(); 
?>