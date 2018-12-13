<?php
session_start();

if(isset($_SESSION["CompraModificada"])){

	$compraMod=$_SESSION["CompraModificada"];

	unset($_SESSION["CompraModificada"]);

include_once("gestionBD.php");
include_once("gestionarCompras.php");

$conexion= crearConexionBD();
$res= borrar_compra($conexion,$compraMod["IDCOMPRAS"]);
cerrarConexionBD($conexion);

if($res!=true){
	$_SESSION["excepcion"]="Error al borrar una compra";
	header("location: excepcion.php");
}
else{

	header("location: consultarCompras.php");
}

}
else{
	header("location: consultarCompras.php");
}

?>