<?php
session_start();
include_once("gestionBD.php");
include_once("gestionarClientes.php");

if (isset($_REQUEST["submit"])) {
	$usuario=$_REQUEST["Nickname"];
	$pass=$_REQUEST["Password"];

		$conexion = crearConexionBD();
		$num_clientes=consultarClientes($conexion,$usuario,$pass);
		cerrarConexionBD($conexion);

		if ($num_clientes==0) {
			$_SESSION["errorLoginCliente"]="error";
			
		}
		else{
			$_SESSION["loginCliente"]=$usuario;
		}

	header("location: Pagina inicio.php");

}
else if(isset($_REQUEST["salirCliente"])){
	$_SESSION["loginCliente"]=null;
	header("location: Pagina inicio.php");

}

else{
	header("location: Pagina inicio.php");
}

?>