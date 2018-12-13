<?php
session_start();

if (isset($_REQUEST["IDCLIENTE"])) {
	$clienteMod["IDCLIENTE"]=$_REQUEST["IDCLIENTE"];
	$clienteMod["NOMBRE"]=$_REQUEST["NOMBRE"];
	$clienteMod["APELLIDOS"]=$_REQUEST["APELLIDOS"];
	$clienteMod["CORREO"]=$_REQUEST["CORREO"];
	

	$_SESSION["clienteMod"]=$clienteMod;


}



?>