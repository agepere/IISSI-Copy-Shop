<?php
	session_start();
	require_once("gestionBD.php");
	require_once("gestionarDetalleCompra.php");

	if(isset($_REQUEST["IDCOMPRAS"])){

		$compraMod["IDCOMPRAS"]=$_REQUEST["IDCOMPRAS"];
		$compraMod["FECHACOMPRA"]=$_REQUEST["FECHACOMPRA"];
		$compraMod["TOTAL"]=$_REQUEST["TOTAL"];
		$compraMod["IDPROVEEDOR"]=$_REQUEST["IDPROVEEDOR"];

		$_SESSION["CompraModificada"]=$compraMod;
	}
	if (isset($_REQUEST["borrarCom"])) {
			
			header("Location: accion_borrar_compra.php");

    } else if (isset($_REQUEST["insertarCom"])) {
				
			header("Location: accionInsertarCompras.php");

	} else if (isset($_REQUEST["detCom"])) {
			$_SESSION["details"]=$compraMod["IDCOMPRAS"];
				unset($_SESSION["CompraModificada"]);
			header("Location: consultarCompras.php");

	}else if (isset($_REQUEST["Eliminar"])){
			$_SESSION["details"]=$compraMod["idCompra"]; //para abrir el mismo detalle que estaba abierto
			$conexion=crearConexionBD();
			$res=eliminarDetalleCompra ($conexion, $_REQUEST["idDetalleCompra"]);
			cerrarConexionBD($conexion);
			unset($_SESSION["CompraModificada"]);
			if($res==true)
			header("location: consultarCompras.php");
			else{
				$_SESSION["excepcion"]="Error al borrar el detalle de la compra";
				header("location: excepcion.php");

		}

	  }else if (isset($_REQUEST["detComAdd"])) {
			//volvemos al consultar para mostrar el formulario
			$_SESSION["formularioDet"]=$_REQUEST["IDCOMPRAS"];
			unset($_SESSION["CompraModificada"]);
			header("Location: consultarCompras.php");
			
		}else{
			
			header("Location: consultarCompras.php" );

		}
	?>