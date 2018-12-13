<?php
   function consultarDetalleCompra($conexion,$IDCOMPRA){
	$consulta="SELECT * FROM DETALLECOMPRA WHERE (IDCOMPRAS=:idcompra)";
	try{
	$stmt=$conexion->prepare($consulta);
	$stmt->bindParam(":idcompra",$IDCOMPRA);
	$stmt->execute();
	return $stmt->fetchAll();
	}
			catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar el detalle de la compra";
 		header("location: excepcion.php");
 	}
}

 function getCatalogoId($conexion,$idcatalogo){
  	try{
	$consulta="SELECT * FROM CATALOGO WHERE IDCATALOGO=:idcatalogo";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':idcatalogo',$idcatalogo);
	
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al obtener el catalogo ";
		$_SESSION["destino"] = "consultarCompras.php";
 		header("location: excepcion.php");
 	}

}


function insertarDetalleCompra($conexion,$detallecompra){
	try {
		$consulta=('CALL INSERTAR_DETALLECOMPRA(:CANTIDAD,:PRECIOCOMPRA,:IVA,:IDCOMPRAS,:IDCATALOGO)');
		$stmt=$conexion->prepare($consulta);
 		$stmt->bindParam(':CANTIDAD',$detallecompra["CANTIDAD"]);
 		$stmt->bindParam(':PRECIOCOMPRA',$detallecompra["PRECIOCOMPRA"]);
 		$stmt->bindParam(':IVA',$detallecompra["IVA"]);
 		$stmt->bindParam(':IDCOMPRAS',$detallecompra["IDCOMPRAS"]);
 		$stmt->bindParam(':IDCATALOGO',$detallecompra["IDCATALOGO"]);
 		
 		$stmt->execute();
 		return true;
	}
 	catch(PDOexception $e){
 		return false;
 	}
}

function eliminarDetalleCompra($conexion,$IDDETALLECOMPRA){
	try{
		$consulta=('CALL ELIMINAR_DETALLECOMPRA(:idDetCom)');
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':idDetCom',$IDDETALLECOMPRA);
		$stmt->execute();
		return true;
	}
		catch(PDOexception $e){
		return false;
	}
}
?>



