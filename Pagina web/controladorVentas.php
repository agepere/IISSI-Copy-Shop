<?php
	session_start();
	require_once("gestionBD.php");
	require_once("gestionarDetalleVenta.php");
	require_once("gestionarVentas.php");

	if(isset($_REQUEST["IDVENTAS"])){
		$ventaMod["IDVENTAS"]=$_REQUEST["IDVENTAS"];
		$ventaMod["IDCLIENTE"]=$_REQUEST["IDCLIENTE"];
		$ventaMod["IDEMPLEADO"]=$_REQUEST["IDEMPLEADO"];
		$ventaMod["FECHAVENTA"]=$_REQUEST["FECHAVENTA"];
		$ventaMod["TOTAL"]=$_REQUEST["TOTAL"];	

		$_SESSION["VentaModificada"]=$ventaMod;
	}
		if(isset($_REQUEST["insertarVenta"])) {
			header("Location: accionInsertarVentas.php");
		}
		else if(isset($_REQUEST["borrarVenta"])) {
			header("Location: accion_borrar_ventas.php");
		}
		else if (isset($_REQUEST["addDetalles"])) {
			//volvemos al consultar para mostrar el formulario
			$_SESSION["formularioDet"]=$_REQUEST["IDVENTAS"];
			unset($_SESSION["VentaModificada"]);
			header("Location: consultarVentas.php");
			
		}
		else if(isset($_REQUEST["verDetalles"])){
			$_SESSION["detalles"]=$ventaMod["IDVENTAS"];
			unset($_SESSION["VentaModificada"]);
			header("Location: consultarVentas.php");
			 //solo se usa para insertar o borrar

		}
		else if(isset($_REQUEST["EliminarDetalle"])){
			$_SESSION["detalles"]=$_REQUEST["idVenta"]; //para abrir el mismo detalle que estaba abierto

			$conexion=crearConexionBD();
			$hoy=ventaHoy($conexion,$_REQUEST["idVenta"]);
			$Deta= getDetallePorId($conexion,$_REQUEST["idDetalleVenta"]);
			if ($hoy=="true" && $Deta["IDVENTAS"]==$_REQUEST["idVenta"]){
			$res=eliminarDetalleVenta ($conexion, $_REQUEST["idDetalleVenta"]);

		}
		else{
			$res=true;// Para no ir a excepción
			$erroresDet[]="Esa venta no es modificable";
			$_SESSION["erroresDet"]=$erroresDet;
		}
			cerrarConexionBD($conexion);
			unset($_SESSION["VentaModificada"]);
			if($res==true)
			header("location: consultarVentas.php");
			else{
				$_SESSION["excepcion"]="Error al borrar el detalle de la venta";
				header("location: excepcion.php");

		}
		}
		else{
			header("Location: consultarVentas.php");
		}
	?>