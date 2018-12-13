<?php
  

  function consultarDetalleVenta($conexion,$idventas){
  		$consulta="SELECT * FROM DETALLEVENTA WHERE IDVENTAS=:idv";
  	try{	
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':idv',$idventas);
	
	$stmt->execute();
	return $stmt->fetchAll();
}
catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar los detalles de la venta";
 		header("location: excepcion.php");
 	}

  }
  function getCatalogoPorId($conexion,$idcatalogo){
  	try{
	$consulta="SELECT * FROM CATALOGO WHERE IDCATALOGO=:idcat";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':idcat',$idcatalogo);
	
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al obetener el catalogo por el id del mismo";
 		header("location: excepcion.php");
 	}

}

function getDetallePorId($conexion,$idDeta){
  	try{
	$consulta="SELECT * FROM DETALLEVENTA WHERE IDDETALLEVENTA=:idDet";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':idDet',$idDeta);
	
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al obtener el detalle de la venta por el id";
 		header("location: excepcion.php");
 	}

}

function eliminarDetalleVenta ($conexion, $iddet){
	try {
		$stmt=$conexion->prepare('CALL ELIMINAR_DETALLEVENTA(:iddet)');
		$stmt->bindParam(':iddet',$iddet);
		$stmt->execute();
		return true;
	} catch(PDOException $e) {
		return false;
    }


}

function insertarDetalleVenta($conexion,$detalleVenta){
	try{

 	
 		$consulta="CALL INSERTAR_DETALLEVENTA(:cantidad,:precio,:iva,:idventa,:idcatalogo)";
 		$stmt=$conexion->prepare($consulta);
 		$stmt->bindParam(':cantidad',$detalleVenta["CANTIDAD"]);
 		$stmt->bindParam(':precio',$detalleVenta["PRECIOVENTA"]);
 		$stmt->bindParam(':iva',$detalleVenta["IVA"]);
 		$stmt->bindParam(':idventa',$detalleVenta["IDVENTAS"]);
 		$stmt->bindParam(':idcatalogo',$detalleVenta["IDCATALOGO"]);
 		

 		$stmt->execute();
 		return true;
 	}
 	catch(PDOexception $e){
 		return false;
 	}
}
  


  ?>