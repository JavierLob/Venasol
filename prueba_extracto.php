<?php 
session_start();

$HTML = file_get_contents("http://localhost/venasol/vista/?modulo=cliente/registrar_cliente");

print($HTML);
 ?>