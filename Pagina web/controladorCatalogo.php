<?php
session_start();

if (isset($_REQUEST["IDCATALOGO"])) {
	$catMod["IDCATALOGO"]=$_REQUEST["IDCATALOGO"];
	$catMod["NOMBRE"]=$_REQUEST["NOMBRE"];
	$catMod["DESCRIPCION"]=$_REQUEST["DESCRIPCION"];
	$catMod["PRECIO"]=$_REQUEST["PRECIO"];
	$catMod["IVA"]=$_REQUEST["IVA"];
	$catMod["STOCK"]=$_REQUEST["STOCK"];
	$catMod["STOCKMINIMO"]=$_REQUEST["STOCKMINIMO"];
	$catMod["TIPOPRODUCTO"]=$_REQUEST["TIPOPRODUCTO"];
	$catMod["TIPOCATALOGO"]=$_REQUEST["TIPOCATALOGO"];

	if (isset($_REQUEST["confirmar"])){
			$precio=$_REQUEST["precioMod"];
			if($precio<0 || $precio==null || $precio==""){ //VALIDAMOS EN SERVIDOR
				$_SESSION["errorAct"]="El precio debe de ser mayor que 0";
				if($_REQUEST["TIPOCATALOGO"]== "Producto"){
					header("location: consultarCatalogoProducto.php ");
				}else if($_REQUEST["TIPOCATALOGO"]== "Servicio") {
					header("location: consultarCatalogoServicio.php ");
				}
				
		}

			else{

		$catMod["PRECIO"]=$precio;
		
		}


	}



	$_SESSION["catMod"]=$catMod;


}

if (isset($_REQUEST["borrarCat"])) {
	header("location: accionBorrarCatalogo.php");
}else if(isset($_REQUEST["actPrecio"])){
	if($_REQUEST["TIPOCATALOGO"]== "Producto"){
		header("location: consultarCatalogoProducto.php ");
	}else if($_REQUEST["TIPOCATALOGO"]== "Servicio") {
		header("location: consultarCatalogoServicio.php ");
	}else{
		$_SESSION["excepcion"]="Error al borrar el catalogo";
		header("location: excepcion.php");
	}
	
}else if(isset($_REQUEST["confirmar"])){
	header("location: accionActualizarCatalogo.php");
}



?>