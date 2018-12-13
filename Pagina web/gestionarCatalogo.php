<?php
  function consultar_catalogo($conexion){
    $consulta="SELECT * FROM CATALOGO ORDER BY TIPOCATALOGO DESC,NOMBRE";

    return $conexion->query($consulta);

  }

 function alta_catalogo($conexion,$catalogo) {
 	
 	try{
 		$consulta = "CALL INSERTAR_CATALOGOS(:Nombre,:Descripcion,:Precio,:IVA,:Stock,:StockMinimo,:TipoProducto,:TipoCatalogo)";
 		$stmt = $conexion->prepare($consulta);
 		
 		$stmt->bindParam(':Nombre',$catalogo["Nombre"]);
 		$stmt->bindParam(':Descripcion',$catalogo["Descripcion"]);
 		$stmt->bindParam(':Precio',$catalogo["Precio"]);
 		$stmt->bindParam(':IVA',$catalogo["IVA"]);
 		$stmt->bindParam(':Stock',$catalogo["Stock"]);
 		$stmt->bindParam(':StockMinimo',$catalogo["StockMinimo"]);
 		$stmt->bindParam(':TipoProducto',$catalogo["TipoProducto"]);
 		$stmt->bindParam(':TipoCatalogo',$catalogo["TipoCatalogo"]);
        
        $stmt->execute();
        return true;

 	}catch(PDOException $e){
 		return false;
 	}
	
	
}
function consultarCatalogo($conexion,$catalogo){
	try{
	$consulta="SELECT COUNT(*) FROM CATALOGO WHERE IDCATALOGO=:IDCATALOGO";
	$stmt = $conexion->prepare($consulta);
	$stmt->execute();
	return $stmt->fetchColumn();
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar el catalogo";
 		header("location: excepcion.php");
 	}
}
function eliminarCatalogo($conexion,$IDCATALOGO){
	try {
		$stmt=$conexion->prepare('CALL ELIMINAR_CATALOGOS(:idcat)');
		$stmt->bindParam(':idcat',$IDCATALOGO);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
	return $e->getMessage();
    }
}

function actualizaCatalogo($conexion,$IDCATALOGO,$PRECIO){
	try{
		$stmt=$conexion->prepare('CALL ACTUALIZA_CATALOGO(:idcat,:dinero)');
		$stmt->bindParam(':idcat',$IDCATALOGO);
		$stmt->bindParam(':dinero',$PRECIO);
		$stmt->execute();
		return "";

	}
	catch(PDOException $e){
		return $e->getMessage();

	}

}
?>
