<?php
  function consultar_empleados($conexion){
  	$consulta="SELECT * FROM EMPLEADOS ORDER BY IDEMPLEADO";

  	return $conexion->query($consulta);

  }







 function alta_empleado($conexion,$empleado) {
 	//EXECUTE INSERTAR_EMPLEADOS('32094173L','admin', 'admin', 'admin', 'admin', 1000, '31/7/1997', null, '19', '638075958', 'admin', 'admin');

 		$FechaInicio=date('d/m/Y', strtotime($empleado["FechaInicio"]));
 		if($empleado["FechaFin"]==""){
 			$FechaFin=null;
 		}
 		else{
 			$FechaFin=date('d/m/Y', strtotime($empleado["FechaFin"]));
 		}
 		try{

 	
 		$consulta="CALL INSERTAR_EMPLEADOS(:dni, :nombre, :ape, :dir, :email,:fechai, :fechaf, :edad, :tlf, :usuario, :pass)";
 		$stmt=$conexion->prepare($consulta);
 		$stmt->bindParam(':dni',$empleado["DNI"]);
 		$stmt->bindParam(':nombre',$empleado["Nombre"]);
 		$stmt->bindParam(':ape',$empleado["Apellidos"]);
 		$stmt->bindParam(':dir',$empleado["Direccion"]);
 		$stmt->bindParam(':email',$empleado["Email"]);
 		$stmt->bindParam(':fechai',$FechaInicio);
 		$stmt->bindParam(':fechaf',$FechaFin);

 		$stmt->bindParam(':edad',$empleado["Edad"]);
 		$stmt->bindParam(':tlf',$empleado["Telefono"]);
 		$stmt->bindParam(':usuario',$empleado["Nickname"]);
 		$stmt->bindParam(':pass',$empleado["Password"]);

 		$stmt->execute();
 		return true;
 	}
 	catch(PDOexception $e){
 		return false;
 	}

}



function consultarEmpleados($conexion,$usuario,$pass){
	try{
	$consulta="SELECT COUNT(*) FROM EMPLEADOS WHERE USUARIO=:usuario AND PASS=:pass";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':usuario',$usuario);
	$stmt->bindParam(':pass',$pass);
	$stmt->execute();
	return $stmt->fetchColumn();
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar los empleados";
 		header("location: excepcion.php");
 	}
}
function consultarEmpleadoLogeado($conexion,$usuario){
	try{
	$consulta="SELECT * FROM EMPLEADOS WHERE USUARIO=:usuario";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':usuario',$usuario);
	
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar los empleados logeados";
 		header("location: excepcion.php");
 	}
}
function consultarEmpleadoPorId($conexion,$ide){
	try{
	$consulta="SELECT * FROM EMPLEADOS WHERE IDEMPLEADO=:idmp";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':idmp',$ide);
	
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar los empleados por id";
 		header("location: excepcion.php");
 	}

}


function eliminarEmpleado($conexion,$IDEMPLEADO){
	try {
		$stmt=$conexion->prepare('CALL ELIMINAR_EMPLEADOS(:idemp)');
		$stmt->bindParam(':idemp',$IDEMPLEADO);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }

	
}

function despedirEmpleado($conexion,$IDEMPLEADO){
	try{
		$stmt=$conexion->prepare('CALL DESPEDIR_EMPLEADO(:idemp)');
		$stmt->bindParam(':idemp',$IDEMPLEADO);
		$stmt->execute();
		return "";

	}
	catch(PDOException $e){
		return $e->getMessage();

	}
}

function actualizaEmpleado($conexion,$IDEMPLEADO,$CORREO,$SALARIO){
	try{
		$stmt=$conexion->prepare('CALL ACTUALIZA_EMPLEADO(:idemp,:email,:sueldo)');
		$stmt->bindParam(':idemp',$IDEMPLEADO);
		$stmt->bindParam(':email',$CORREO);
		$stmt->bindParam(':sueldo',$SALARIO);
		$stmt->execute();
		return "";

	}
	catch(PDOException $e){
		return $e->getMessage();

	}

}

?>