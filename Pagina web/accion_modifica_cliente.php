<?php
session_start();

if(!isset($_REQUEST["actCliente"])){
	header("location: Pagina inicio.php");
}
else{
	$nuevoCliente["IDCLIENTE"]=$_REQUEST["IDCLIENTE"];
	$nuevoCliente["NIF"]=$_REQUEST["NIF"];
	$nuevoCliente["Nombre"]=$_REQUEST["Nombre"];
	$nuevoCliente["Apellidos"]=$_REQUEST["Apellidos"];
	$nuevoCliente["Email"]=$_REQUEST["Email"];
	$nuevoCliente["Direccion"]=$_REQUEST["Direccion"];
	$nuevoCliente["Telefono"]=$_REQUEST["Telefono"];
	$nuevoCliente["Tipo"]=$_REQUEST["Tipo"];
	$nuevoCliente["Nickname"]=$_REQUEST["Nickname"];
	$nuevoCliente["Password"]=$_REQUEST["Password"];
	$nuevoCliente["ConfirmarPassword"]= $_REQUEST["ConfirmarPassword"];


}
$erroresCliente = validarDatosCliente($nuevoCliente);
	
	// Si se han detectado errores
	if (count($erroresCliente)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresCliente"] = $erroresCliente;
		Header('Location: formularioModificaCliente.php');
	} else{
		// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)

		$_SESSION["formModCliente"]=$nuevoCliente;
		Header('Location: exito_modifica_cliente.php');
}

function validarDatosCliente($nuevoCliente){

			//Validacion del NIF

			

			if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoCliente["NIF"])){
				$erroresCliente[]="El NIF debe comenzar por ocho dígitos y a continuación una letra mayúscula	";

			}

					//Validacion del nombre

			

			
			 if(strlen($nuevoCliente["Nombre"])>50){
				$erroresCliente[]="El Nombre no puede tener mas de 50 caracteres";
			}

				//Validacion del apellido

			 if(strlen($nuevoCliente["Apellidos"])>50){
				$erroresCliente[]="Los apellidos no pueden tener mas de 50 caracteres";
			}

				//Validacion del email
			
			
			 if(!filter_var($nuevoCliente["Email"],  FILTER_VALIDATE_EMAIL)){
				$erroresCliente[]="El email no tiene el formato correcto: x@x.x";
			}

				//Validacion de la dirección

			
			 if(strlen($nuevoCliente["Direccion"])>100){
				$erroresCliente[]="La dirección no puede tener mas de 100 caracteres";
			}


				//Validación del telefono

			

			 if(strlen($nuevoCliente["Telefono"])>9){
				$erroresCliente[]="El teléfono no puede tener mas de 9 caracteres";
			}

				//Validación del Tipo

			if($nuevoCliente["Tipo"]==""){
				$erroresCliente[]="El tipo no puede estar vacío.";
			}

			else if($nuevoCliente["Tipo"]!= "Universitario" && $nuevoCliente["Tipo"]!= "NoUniversitario"){		
				$erroresCliente[]="El tipo debe ser Universitario o No Universitario";
			}



				//Validación pass

			if ($nuevoCliente["Password"]=="") {
				$erroresCliente[]="Las contraseñas no pueden estar vacías";

			}
			else if(strlen($nuevoCliente["Password"])>50){
				$erroresCliente[]="La contraseña no puede tener mas de 50 caracteres";
			}

			else if($nuevoCliente["Password"] != $nuevoCliente["ConfirmarPassword"]){
				$erroresCliente[]="Las contraseñas no coinciden";
			}	

			
			return $erroresCliente;

	}

?>

