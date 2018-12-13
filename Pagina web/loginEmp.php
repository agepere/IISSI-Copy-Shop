<?php
session_start();
include_once("gestionBD.php");
include_once("gestionarEmpleados.php");

if (isset($_REQUEST["submit"])) {
	$usuario=$_REQUEST["Nickname"];
	$pass=$_REQUEST["Password"];

		$conexion = crearConexionBD();
		$num_empleados=consultarEmpleados($conexion,$usuario,$pass);
		cerrarConexionBD($conexion);

		if ($num_empleados==0) {
			$_SESSION["errorLoginEmp"]="error";
			
		}
		else{
			$_SESSION["loginEmp"]=$usuario;
		}

	header("location: empleados.php");

}
else if(isset($_REQUEST["salirEmp"])){
	$_SESSION["loginEmp"]=null;
	header("location: Pagina inicio.php");

}
else{
	header("location: empleados.php");
}

?>

