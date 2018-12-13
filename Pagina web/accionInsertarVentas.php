<?php	
	session_start();	
	
	if(isset($_REQUEST["insertarVenta"])){
		
		require_once("gestionBD.php");
		require_once("gestionarVentas.php");
		require_once("gestionarEmpleados.php");
		require_once("gestionarClientes.php");
		
		$conexion = crearConexionBD();
		$empleado=consultarEmpleadoLogeado($conexion,$_SESSION["loginEmp"]);
		$Idemp=$empleado["IDEMPLEADO"];	
		
		if($_REQUEST["nickCliente"]=="" || !isset($_REQUEST["nickCliente"]))
				$excepcion = insertar_ventas($conexion,$Idemp);
		else {
			$numCli=consultaGetCliente($conexion,$_REQUEST["nickCliente"]);
			if ($numCli>=1) {
				$cliente=getCliente($conexion,$_REQUEST["nickCliente"]);
				
				$excepcion=insertar_ventas_conCliente($conexion,$Idemp,$cliente["IDCLIENTE"]);

			}
			else{
				$error="Lo sentimos,no hay ningún cliente con ese nick";
				$excepcion=true; //Para que no nos lleve a excecion.php
				$_SESSION["clienteNoValido"]= $error;
				header("location: consultarVentas.php");
			}
}
		
		cerrarConexionBD($conexion);
			
		if($excepcion==false){
			$_SESSION["excepcion"]="Error al insertar la venta";
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