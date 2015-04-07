<?php
date_default_timezone_set('America/Caracas');
ob_end_clean();
require_once("../libreria/fpdf/clsFpdf.php");
require_once('../clases/clase_factura.php');

$lobjPdf=new clsFpdf();
$lobjFactura=new clsFactura();
$lobjPdf->AliasNbPages();
$lobjPdf->AddPage("P","Letter");
$idfactura=(isset($_GET['id']))?$_GET['id']:'2';
$lobjFactura->set_Factura($idfactura);
$laFactura=$lobjFactura->consultar_factura();
$laFactura_Productos=$lobjFactura->consultar_productos_factura();
$laFactura_Precintos=$lobjFactura->consultar_precintos_factura();
$laFactura['nacionalidadcho']=substr($laFactura['cedula_rifcho'], 0,1);
$laFactura['cedula_rifcho']=number_format(substr($laFactura['cedula_rifcho'], 1,strlen($laFactura['cedula_rifcho'])),0,'','.');

$lobjPdf->SetTextColor(50,50,50);

$lobjPdf->SetFont("arial","B",10);
$lobjPdf->Cell(0,6,utf8_decode("FORMA LIBRE"),0,1,"R");

$lobjPdf->SetFillColor(240,240,240);
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->Cell(160,6,utf8_decode("DATOS DEL CLIENTE"),"B",0,"C",true);
$lobjPdf->Cell(40,6,utf8_decode("Nº DE CONTROL"),"B",1,"C",true);
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->Cell(15,6,utf8_decode("Cliente: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(145,6,utf8_decode($laFactura['razonsocial']),0,0,"L");
$lobjPdf->SetFont("arial","B",10);
$lobjPdf->SetTextColor(220,50,50);
$lobjPdf->Cell(40,6,utf8_decode($laFactura['idfactura']),"L",1,"C");
$lobjPdf->SetTextColor(50,50,50);
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->Cell(15,6,utf8_decode("RIF: "),0,0,"L");
$lobjPdf->SetFont("arial","",10);
$lobjPdf->Cell(145,6,utf8_decode($laFactura['rifcli']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(40,6,utf8_decode("FECHA: ".$laFactura['fechafac']),"L",1,"C",true);

$lobjPdf->Cell(15,6,utf8_decode("Dirección: "),0,0,"L");
$lobjPdf->SetFont("arial","",10);
$lobjPdf->MultiCell(145,6,utf8_decode($laFactura['direccioncli']),0,"L");

$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(50,6,utf8_decode("DATOS CHOFER"),"B",0,"C",true);
$lobjPdf->Cell(75,6,utf8_decode("DATOS VEHÍCULO"),"B",0,"C",true);
$lobjPdf->Cell(75,6,utf8_decode("DATOS ACCESORIO"),"B",1,"C",true);

$lobjPdf->Cell(12,6,utf8_decode("Nombre: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(38,6,utf8_decode($laFactura['nombrecho'].' '.$laFactura['apellidocho']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->Cell(12,6,utf8_decode("Placa: "),"L",0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(15,6,utf8_decode($laFactura['placaveh']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(10,6,utf8_decode("Color: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(25,6,utf8_decode($laFactura['colorveh']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->Cell(15,6,utf8_decode("Placa: "),"L",0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['placaacc']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(10,6,utf8_decode("Color: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(35,6,utf8_decode($laFactura['coloracc']),0,1,"L");
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(12,6,utf8_decode("C.I. : "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(38,6,utf8_decode($laFactura['nacionalidadcho'].'-'.$laFactura['cedula_rifcho']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);

$lobjPdf->Cell(12,6,utf8_decode("Año: "),"L",0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(15,6,utf8_decode($laFactura['anoveh']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(10,6,utf8_decode("Marca: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(25,6,utf8_decode($laFactura['marcaveh']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);



$lobjPdf->Cell(15,6,utf8_decode("Año: "),"L",0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(20,6,utf8_decode($laFactura['anoacc']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(10,6,utf8_decode("Marca: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(35,6,utf8_decode($laFactura['marcaacc']),0,1,"L");

$lobjPdf->SetX(60);
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(12,6,utf8_decode("Modelo: "),"L",0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(50,6,utf8_decode($laFactura['modeloveh']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);


$lobjPdf->Cell(15,6,utf8_decode("Capacidad: "),"L",0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(20,6,utf8_decode(number_format($laFactura['capacidadacc'],0,'','.').' '.$laFactura['unidadmedidaacc']),0,0,"L");
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(10,6,utf8_decode("Modelo: "),0,0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->Cell(35,6,utf8_decode($laFactura['modeloacc']),0,1,"L");

$lobjPdf->SetX(122);
$lobjPdf->SetFont("arial","B",8);
$lobjPdf->Cell(15,6,utf8_decode("Precintos: "),"L",0,"L");
$lobjPdf->SetFont("arial","",8);
$lobjPdf->MultiCell(60,6,utf8_decode($laFactura_Precintos['codigopre']),0,"L");

$lobjPdf->SetFont("arial","B",10);
$lobjPdf->Cell(30,6,utf8_decode("CANTIDAD"),"B",0,"C",true);
$lobjPdf->Cell(110,6,utf8_decode("DESCRIPCIÓN"),"B",0,"C",true);
$lobjPdf->Cell(30,6,utf8_decode("PRECIO UNIT"),"B",0,"C",true);
$lobjPdf->Cell(30,6,utf8_decode("TOTAL"),"B",1,"C",true);

$lobjPdf->SetFont("arial","",10);
for($i=0;$i<count($laFactura_Productos);$i++)
{
	$subTotal=$laFactura_Productos[$i]['cantidadpro']*$laFactura_Productos[$i]['preciopro'];
	$Total=$Total+$subTotal;

	$lobjPdf->Cell(30,6,utf8_decode(number_format($laFactura_Productos[$i]['cantidadpro'],0,'','.').' '.$laFactura_Productos[$i]['unidadmedidapro']),1,0,"C");
	$lobjPdf->SetFont("arial","B",8);	
	$lobjPdf->Cell(110,6,utf8_decode($laFactura_Productos[$i]['descripcionlargapro'].' ('.$laFactura_Productos[$i]['descripcioncortapro'].')'),1,0,"C");
	$lobjPdf->SetFont("arial","B",10);
	$lobjPdf->Cell(30,6,utf8_decode($laFactura_Productos[$i]['preciopro'].'Bs'),1,0,"C");
	$lobjPdf->Cell(30,6,utf8_decode($subTotal),1,1,"C");
}

$lobjPdf->SetX(150);
$lobjPdf->SetFont("arial","B",10);
$lobjPdf->Cell(30,6,utf8_decode("SUB-TOTAL: "),1,0,"R",true);
$lobjPdf->SetFont("arial","",10);
$lobjPdf->Cell(30,6,utf8_decode($laFactura['totalfac']-$laFactura['ivafac']),1,1,"C");

$lobjPdf->SetX(150);
$lobjPdf->SetFont("arial","B",10);
$lobjPdf->Cell(30,6,utf8_decode("IVA: "),1,0,"R",true);
$lobjPdf->SetFont("arial","",10);
$lobjPdf->Cell(30,6,utf8_decode($laFactura['ivafac']),1,1,"C");
$lobjPdf->SetFont("arial","B",10);

$lobjPdf->SetX(150);
$lobjPdf->Cell(30,6,utf8_decode("TOTAL: "),1,0,"R",true);
$lobjPdf->SetFont("arial","",10);
$lobjPdf->Cell(30,6,utf8_decode($laFactura['totalfac']),1,1,"C");

$lobjPdf->Ln(5);
$lobjPdf->SetTextColor(10,10,10);

$lobjPdf->SetFont("arial","B",10);
$lobjPdf->Cell(20,6,utf8_decode("NOTA: "),0,1,"L");
$lobjPdf->SetFont("arial","",10);
$lobjPdf->MultiCell(200,6,utf8_decode($laFactura['observacionfac']),1,"L");
$lobjPdf->Ln(15);

$lobjPdf->SetY(-65);
$lobjPdf->SetX(75);
$lobjPdf->Cell(70,35,utf8_decode(""),1,1,"C");
$lobjPdf->SetFont("arial","B",10);

$lobjPdf->Cell(0,6,utf8_decode("SELLO"),0,1,"C");

$lobjPdf->Output(); 
?>