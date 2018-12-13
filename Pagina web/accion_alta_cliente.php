<?php 
session_start();

/*Comprobamos que venimos del formulario */

if(isset($_SESSION["formularioClientes"])){
	//Recogemos los datos del formulario
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
/*En caso contrario redireccionamos de nuevo al formulario*/

else{
header("location: formularioClientes.php");
}

$_SESSION["formularioClientes"]= $nuevoCliente;

// Validamos el formulario en servidor 
	$erroresCliente = validarDatosCliente($nuevoCliente);
	
	// Si se han detectado errores
	if (count($erroresCliente)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresCliente"] = $erroresCliente;
		Header('Location: formularioClientes.php');
	} else
		// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
		Header('Location: exito_alta_cliente.php');



		function validarDatosCliente($nuevoCliente){

			//Validacion del NIF

			if ($nuevoCliente["NIF"]=="") {
				$erroresCliente[]="El NIF no puede estar vacio.";
			}

			else if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoCliente["NIF"])){
				$erroresCliente[]="El NIF debe comenzar por ocho dígitos y a continuación una letra mayúscula	";

			}

					//Validacion del nombre

			if($nuevoCliente["Nombre"]==""){
				$erroresCliente[]="El nombre no debe estar vacío";

			}
			else if(strlen($nuevoCliente["Nombre"])>50){
				$erroresCliente[]="El Nombre no puede tener mas de 50 caracteres";
			}

				//Validacion del apellido

			 if(strlen($nuevoCliente["Apellidos"])>50){
				$erroresCliente[]="Los apellidos no pueden tener mas de 50 caracteres";
			}

				//Validacion del email
			if($nuevoCliente["Email"]==""){
				$erroresCliente[]="El email no puede estar vacio";

			}
			else if(!filter_var($nuevoCliente["Email"],  FILTER_VALIDATE_EMAIL)){
				$erroresCliente[]="El email no tiene el formato correcto: x@x.x";
			}

				//Validacion de la dirección

			if($nuevoCliente["Direccion"]==""){
				$erroresCliente[]="La dirección no puedo estar vacía.";
			}
			else if(strlen($nuevoCliente["Direccion"])>100){
				$erroresCliente[]="La dirección no puede tener mas de 100 caracteres";
			}


				//Validación del telefono

			if($nuevoCliente["Telefono"]==""){
				$erroresCliente[]="El teléfono no puede estar vacío.";
			}

			else if(strlen($nuevoCliente["Telefono"])>9){
				$erroresCliente[]="El teléfono no puede tener mas de 9 caracteres";
			}

				//Validación del Tipo

			if($nuevoCliente["Tipo"]==""){
				$erroresCliente[]="El tipo no puede estar vacío.";
			}

			else if($nuevoCliente["Tipo"]!= "Universitario" && $nuevoCliente["Tipo"]!= "NoUniversitario"){		
				$erroresCliente[]="El tipo debe ser Universitario o No Universitario";
			}

				// Validación Nick

			if ($nuevoCliente["Nickname"]=="") {
				$erroresCliente[]="El nick de usuario no puede estar vacio.";
	
			}
			else if(strlen($nuevoCliente["Nickname"])>50){
				$erroresCliente[]="El Nick no puede tener mas de 50 caracteres";
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