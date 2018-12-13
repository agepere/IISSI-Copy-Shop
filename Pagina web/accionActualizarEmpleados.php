<?php
session_start();

if(isset($_SESSION["empleadoMod"])){
	$empleadoMod=$_SESSION["empleadoMod"];
	unset($_SESSION["empleadoMod"]);

include_once("gestionBD.php");
include_once("gestionarEmpleados.php");

$conexion= crearConexionBD();
$res= actualizaEmpleado($conexion,$empleadoMod["IDEMPLEADO"],$empleadoMod["CORREO"],$empleadoMod["SALARIO"]);
cerrarConexionBD($conexion);

if($res!=""){
	$_SESSION["excepcion"]="Error al actualizar el empleado";
	header("location: excepcion.php");
}
else{
	header("location: consultarEmpleados.php");
}

}
else{
	header("location: consultarEmpleados.php");
}

?>