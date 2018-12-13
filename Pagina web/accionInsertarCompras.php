<?php
session_start();

if(isset($_REQUEST["insertarCom"])){

	
include_once("gestionBD.php");
include_once("gestionarCompras.php");

$conexion= crearConexionBD();
$res= insertar_compras($conexion);
cerrarConexionBD($conexion);

if($res!=true){
	$_SESSION["excepcion"]="Error al insertar una compra";
	header("location: excepcion.php");
}else{

	header("location: consultarCompras.php");
}

}
else{
	header("location: consultarCompras.php");
}

?>