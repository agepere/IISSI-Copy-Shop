<?php
  

function alta_cliente($conexion,$cliente) {
	

	

	try{
		$consulta = "CALL INSERTAR_CLIENTES(:DNI, :NOMBRE, :APELLIDOS, :CORREO, :DIRECCION, :TELEFONO, :TIPO, :USUARIO, :CONTRASEÑA)";

		$stmt= $conexion->prepare($consulta);
		$stmt-> bindParam(':DNI', $cliente["NIF"]);
		$stmt-> bindParam(':NOMBRE', $cliente["Nombre"]);
		$stmt-> bindParam(':APELLIDOS', $cliente["Apellidos"]);
		$stmt-> bindParam(':CORREO', $cliente["Email"]);
		$stmt-> bindParam(':DIRECCION', $cliente["Direccion"]);
		$stmt-> bindParam(':TELEFONO', $cliente["Telefono"]);
		$stmt-> bindParam(':TIPO', $cliente["Tipo"]);
		$stmt-> bindParam(':USUARIO', $cliente["Nickname"]);
		$stmt-> bindParam(':CONTRASEÑA', $cliente["Password"]);
		
		$stmt-> execute();
		return true;

	} catch(PDOException $e){
		return false;
	}
	
}

function consultar_clientes($conexion){
  	$consulta="SELECT * FROM CLIENTES ORDER BY IDCLIENTE";

  	return $conexion->query($consulta);

  }

function consultarClientes($conexion,$usuario,$pass){
	try{
	$consulta="SELECT COUNT(*) FROM CLIENTES WHERE USUARIO=:USUARIO AND PASS=:contra";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':USUARIO',$usuario);
	$stmt->bindParam(':contra',$pass);
	$stmt->execute();
	return $stmt->fetchColumn();
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar los clientes";
 		header("location: excepcion.php");
 	}
}
function consultaGetCliente($conexion,$usuario){
	try{
		$consulta="SELECT COUNT(*) FROM CLIENTES WHERE USUARIO=:nick";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':nick',$usuario);
		$stmt->execute();
		return $stmt->fetchColumn(); 


	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar el get cliente";
 		header("location: excepcion.php");
 	}

}
function getCliente($conexion,$usuario){
	try{
		$consulta="SELECT * FROM CLIENTES WHERE USUARIO=:nick";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':nick',$usuario);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC); //PDO::FETHC_ASSOC PARA ASOCIAR LOS ELEMENTOS CON EL NOMBRE QUE TIENEN EN BD


	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al obtener el cliente";
 		header("location: excepcion.php");
 	}
}
function consultarClientePorId($conexion,$idc){
	try{
	$consulta="SELECT * FROM CLIENTES WHERE IDCLIENTE=:idcl";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':idcl',$idc);
	
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOexception $e){
		$_SESSION["excepcion"]="Error al consultar el cliente por el id";
 		header("location: excepcion.php");
 	}

}


function actualiza_cliente($conexion,$cliente){
	try{
		$consulta = "CALL ACTUALIZA_CLIENTE(:idclien,:DNI, :NOMBRE, :APELLIDOS, :CORREO, :DIRECCION, :TELEFONO, :TIPO, :USUARIO, :CONTRASEÑA)";

		$stmt= $conexion->prepare($consulta);
		$stmt-> bindParam(':idclien', $cliente["IDCLIENTE"]);
		$stmt-> bindParam(':DNI', $cliente["NIF"]);
		$stmt-> bindParam(':NOMBRE', $cliente["Nombre"]);
		$stmt-> bindParam(':APELLIDOS', $cliente["Apellidos"]);
		$stmt-> bindParam(':CORREO', $cliente["Email"]);
		$stmt-> bindParam(':DIRECCION', $cliente["Direccion"]);
		$stmt-> bindParam(':TELEFONO', $cliente["Telefono"]);
		$stmt-> bindParam(':TIPO', $cliente["Tipo"]);
		$stmt-> bindParam(':USUARIO', $cliente["Nickname"]);
		$stmt-> bindParam(':CONTRASEÑA', $cliente["Password"]);
		
		$stmt-> execute();
		return true;

	}
	catch(PDOexception $e){
 		return false;
 	}

}



?>


