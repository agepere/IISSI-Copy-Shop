<?php
session_start();

require_once("gestionBD.php");
require_once("gestionarDetalleCompra.php"); 

if(isset($_REQUEST["confirmarDet"]) ){
	$conexion= crearConexionBD();
	$catalogo=getCatalogoId($conexion,$_REQUEST["IDCATALOGO"]);
	$newDetail["CANTIDAD"]=$_REQUEST["CANTIDAD"];
	$newDetail["IDCOMPRAS"]=$_REQUEST["IDCOMPRAS"];
	$newDetail["IDCATALOGO"]=$_REQUEST["IDCATALOGO"];
	$newDetail["PRECIOCOMPRA"]=$catalogo["PRECIO"];
	$newDetail["IVA"]=$catalogo["IVA"];


$erroresDet=ValidarDatosDetalle($newDetail);

	if($erroresDet==""){

	$res = insertarDetalleCompra($conexion,$newDetail);


	}else{
		$res=true;
		$_SESSION["erroresDet"]=$erroresDet;
	}



	cerrarConexionBD($conexion);



	if($res==true){

		header("location: consultarCompras.php");
	}else{
		$_SESSION["excepcion"]="Error al insertar el detalle de la compra";
		header("location: excepcion.php");
	}
}
else{
	header("location: consultarCompras.php");
}
function ValidarDatosDetalle($Detail){
	$erroresDetalle="";
	if($Detail["CANTIDAD"]<=0)
		$erroresDetalle[]="La cantidad debe ser mayor que cero";
	if ($Detail["IDCATALOGO"]=="none") {
		$erroresDetalle[]="Selecciona un producto o servicio del catalogo";
		
	}
	return $erroresDetalle;
}
?>