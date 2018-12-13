<?php
session_start();
require_once("gestionarDetalleVenta.php");
require_once("gestionBD.php");
require_once("gestionarVentas.php");

if(isset($_REQUEST["confirmarDet"]) ){
	$conexion= crearConexionBD();
	
	$newDetalle["CANTIDAD"]=$_REQUEST["CANTIDAD"];
	$newDetalle["IDVENTAS"]=$_REQUEST["IDVENTAS"];
	$newDetalle["IDCATALOGO"]=$_REQUEST["IDCATALOGO"];
	if ($_REQUEST["IDCATALOGO"]!="none") {
		$catalogo=getCatalogoPorId($conexion,$_REQUEST["IDCATALOGO"]);
	$newDetalle["PRECIOVENTA"]=$catalogo["PRECIO"];
	$newDetalle["IVA"]=$catalogo["IVA"];
	}
	

	$erroresDet=ValidarDatosDetalle($newDetalle,$conexion);

	if($erroresDet=="")

	$res= insertarDetalleVenta($conexion,$newDetalle);

	else{
		$res=true;
		$_SESSION["erroresDet"]=$erroresDet;
	}



	cerrarConexionBD($conexion);



	if($res==true){
	header("location: consultarVentas.php");
	}else{
		$_SESSION["excepcion"]="Error al insertar el detalle de la venta";
		header("location: excepcion.php");
	}

}
else{
	header("location: consultarVentas.php");
}
function ValidarDatosDetalle($Detalle,$conexion){
	$erroresDetalle="";
	if($Detalle["CANTIDAD"]<=0)
		$erroresDetalle[]="La cantidad debe ser mayor que 0.";
	if ($Detalle["IDCATALOGO"]=="none") {
		$erroresDetalle[]="Selecciona un producto o servicio del catalogo.";
		
	}
	$hoy=ventaHoy($conexion,$Detalle["IDVENTAS"]);
	if ($hoy=="false") {
		$erroresDetalle[]="Esa venta no es modificable.";
	}




	return $erroresDetalle;
}
?>