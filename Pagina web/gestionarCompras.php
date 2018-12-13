<?php

function consultar_compra($conexion){
	$consulta="SELECT * FROM COMPRAS ORDER BY IDCOMPRAS";

	return $conexion->query($consulta);
}

function insertar_compras($conexion){
	try {
		$stmt=$conexion->prepare('CALL INSERTAR_COMPRAS(SYSDATE,1)');
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		return false;
	}
}

function borrar_compra($conexion,$IDCOMPRAS){
	try{
		$stmt=$conexion->prepare('CALL ELIMINAR_COMPRAS(:IDCOMPRAS)');
		$stmt->bindParam(':IDCOMPRAS',$IDCOMPRAS);
		$stmt->execute();
		return true;
	}catch(PDOexception $e){
		return false;
	}
}
?>