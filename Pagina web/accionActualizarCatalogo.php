<?php
session_start();

if(isset($_SESSION["catMod"])){
	$catMod=$_SESSION["catMod"];
	unset($_SESSION["catMod"]);



include_once("gestionBD.php");
include_once("gestionarCatalogo.php");

$conexion= crearConexionBD();
$res= actualizaCatalogo($conexion,$catMod["IDCATALOGO"],$catMod["PRECIO"]);
cerrarConexionBD($conexion);

if($res!=""){
	$_SESSION["excepcion"]="Error al actualizar el catalogo";
	header("location: excepcion.php");
}
else{

	if($_SESSION["TIPOCATALOGO"]== "Producto"){
		header("location: consultarCatalogoProducto.php");
	}else if($_SESSION["TIPOCATALOGO"]== "Servicio"){
		header("location: consultarCatalogoServicio.php");
	}else{
		header("location: excepcion.php");
	}
	
}

}
else{
	if($_SESSION["TIPOCATALOGO"]== "Producto"){
		header("location: consultarCatalogoProducto.php");
	}else if($_SESSION["TIPOCATALOGO"]== "Servicio"){
		header("location: consultarCatalogoServicio.php");
	}else{
		header("location: excepcion.php");
	}
}

?>