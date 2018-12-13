<?php
session_start();

if(isset($_SESSION["VentaModificada"])){

	$ventaMod=$_SESSION["VentaModificada"];

	unset($_SESSION["VentaModificada"]);

include_once("gestionBD.php");
include_once("gestionarVentas.php");

$conexion= crearConexionBD();
$hoy=ventaHoy($conexion,$ventaMod["IDVENTAS"]);
if($hoy=="true")
$res= borrar_ventas($conexion,$ventaMod["IDVENTAS"]);
else{
	$res=true;// Para no ir a excepción
			$erroresDet[]="Esa venta no es modificable";
			$_SESSION["erroresDet"]=$erroresDet;
}
cerrarConexionBD($conexion);

if($res!=true){
	$_SESSION["excepcion"]="Error al borrar una venta";
	header("location: excepcion.php");
}

else{

	header("location: consultarVentas.php");
}

}
else{
	header("location: consultarVentas.php");
}

?>