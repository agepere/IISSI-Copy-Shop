<?php

function consultar_venta($conexion){
	$consulta="SELECT * FROM VENTAS ORDER BY IDVENTAS DESC";

	return $conexion->query($consulta);
}

function insertar_ventas($conexion,$idEmp){
	try {
		$stmt=$conexion->prepare('CALL INSERTAR_VENTAS(SYSDATE,:idEmpl,NULL)');
		$stmt->bindParam(':idEmpl',$idEmp);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		return false;
	}
}
function insertar_ventas_conCliente($conexion,$idEmp,$idClien){
	try {
		$stmt=$conexion->prepare('CALL INSERTAR_VENTAS(SYSDATE,:idEmpl,:idCliente)');
		$stmt->bindParam(':idEmpl',$idEmp);
		$stmt->bindParam(':idCliente',$idClien);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		return false;
	}
}

function borrar_ventas($conexion,$IDVENTAS){
	try{
		$stmt=$conexion->prepare('CALL ELIMINAR_VENTAS(:IDVENTAS)');
		$stmt->bindParam(':IDVENTAS',$IDVENTAS);
		$stmt->execute();
		return true;
	}catch(PDOexception $e){
		return false;
	}
}

function ventaHoy($conexion,$IDVENTAS){


	try{
	$consulta="SELECT DISTINCT ventaHoy(:idv,SYSDATE-1) FROM VENTAS";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':idv',$IDVENTAS);
	$stmt->execute();
	return $stmt->fetchColumn();
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al comprobar si la venta se ha hecho hoy.";
 		header("location: excepcion.php");
 	}

}
?>