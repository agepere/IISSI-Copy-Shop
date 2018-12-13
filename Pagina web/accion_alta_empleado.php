
<?php 
session_start();

/*Comprobamos que venimos del formulario viendo si la variable DNI  esta definida  */

if(isset($_SESSION["formularioEmp"])){
	//Recogemos los datos del formulario
$nuevoEmpleado["DNI"]=$_REQUEST["DNI"];
$nuevoEmpleado["Nombre"]=$_REQUEST["Nombre"];
$nuevoEmpleado["Apellidos"]=$_REQUEST["Apellidos"];
$nuevoEmpleado["Email"]=$_REQUEST["Email"];
$nuevoEmpleado["Direccion"]=$_REQUEST["Direccion"];
$nuevoEmpleado["Edad"]=$_REQUEST["Edad"];
$nuevoEmpleado["Telefono"]=$_REQUEST["Telefono"];
$nuevoEmpleado["Nickname"]=$_REQUEST["Nickname"];
$nuevoEmpleado["Password"]=$_REQUEST["Password"];
$nuevoEmpleado["ConfirmarPassword"]= $_REQUEST["ConfirmarPassword"];

$nuevoEmpleado["FechaInicio"]=$_REQUEST["FechaInicio"];
$nuevoEmpleado["FechaFin"]=$_REQUEST["FechaFin"];


}


/*En caso contrario redireccionamos de nuevo al formulario*/

else{
header("Location: formularioEmpleados.php");
}

$_SESSION["formularioEmp"]= $nuevoEmpleado;

// Validamos el formulario en servidor 
	$erroresEmp = validarDatosEmpleado($nuevoEmpleado);
	
	// Si se han detectado errores
	if (count($erroresEmp)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["erroresEmp"] = $erroresEmp;
		 Header('Location: formularioEmpleados.php');
	} else
		// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
		Header('Location: exito_alta_empleado.php');

	function getFechaFormateada($fecha){
		$fechaNacimiento = date('d/n/Y', strtotime($fecha));
		return $fechaNacimiento;
	}

		function validarDatosEmpleado($nuevoEmpleado){

			//Validacion del DNI

			if ($nuevoEmpleado["DNI"]=="") {
				$erroresEmp[]="El DNI no puede estar vacio.";
			}

			else if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoEmpleado["DNI"])){
				$erroresEmp[]="El Dni debe comenzar por ocho dígitos y a continuación una letra mayúscula";

	}
	

	//Validacion del nombre

		if($nuevoEmpleado["Nombre"]==""){
			$erroresEmp[]="El nombre no debe estar vacio";

		}
		else if(strlen($nuevoEmpleado["Nombre"])>50){
		$erroresEmp[]="El Nombre no puede tener mas de 50 caracteres";
	}
		//Validacion del apellido

		if($nuevoEmpleado["Apellidos"]==""){
			$erroresEmp[]="Los Apellidos no deben estar vacios";

		}
			else if(strlen($nuevoEmpleado["Apellidos"])>50){
		$erroresEmp[]="Los apellidos no pueden tener mas de 50 caracteres";
	}

		//Validacion del email
		if($nuevoEmpleado["Email"]==""){
		$erroresEmp[]="El email no puede estar vacio";

	}
	else if(!filter_var($nuevoEmpleado["Email"],  FILTER_VALIDATE_EMAIL))
		$erroresEmp[]="El email no tiene el formato correcto: x@x.x";


	//Validacion de la dirección

	
	if(strlen($nuevoEmpleado["Direccion"])>100){
		$erroresEmp[]="La direccion no puede tener mas de 100 caracteres";
	}

	//Validación de la edad

	if($nuevoEmpleado["Edad"]==""){
		$erroresEmp[]="La edad no puede estar vacía";
	}

	else if ($nuevoEmpleado["Edad"]<16) {
		$erroresEmp[]="La edad debe de ser mayor a 16.";
	}

	//Validación del tlf

	if($nuevoEmpleado["Telefono"]==""){
		$erroresEmp[]="El telefono no puede estar vacío.";
	}

	else if(strlen($nuevoEmpleado["Telefono"])>9){
		$erroresEmp[]="El telefono no puede tener mas de 9 caracteres";
	}

	// Validación Nick

	if ($nuevoEmpleado["Nickname"]=="") {
		$erroresEmp[]="El nick de usuario no puede estar vacio.";

		
	}
		else if(strlen($nuevoEmpleado["Nickname"])>50){
		$erroresEmp[]="El Nick no puede tener mas de 50 caracteres";
	}

	//Validación pass

	if ($nuevoEmpleado["Password"]=="") {
		$erroresEmp[]="Las contraseñas no pueden estar vacías";

	}
		else if(strlen($nuevoEmpleado["Password"])>50){
		$erroresEmp[]="La contraseña no puede tener mas de 50 caracteres";
	}

	else if($nuevoEmpleado["Password"] != $nuevoEmpleado["ConfirmarPassword"])
		$erroresEmp[]="Las contraseñas no coinciden";


	// Validacion fechas
	$fechaUno= explode("/",getFechaFormateada($nuevoEmpleado["FechaInicio"]));
	

	if ($nuevoEmpleado["FechaInicio"]=="") {
		$erroresEmp[]="La fecha de inicio no puede estar vacía";
	}
	

	if($nuevoEmpleado["FechaFin"]!=null && $nuevoEmpleado["FechaFin"]!=""){
		
		$fechaDos=explode("/", getFechaFormateada($nuevoEmpleado["FechaFin"]));
		

		if($fechaDos[2]<$fechaUno[2]){
			$erroresEmp[]="La fecha fin no puede ser anterior a la fecha de inicio";
		}

		else{
			if($fechaDos[2]==$fechaUno[2] && $fechaUno[1]>$fechaDos[1])
				$erroresEmp[]="La fecha fin no puede ser anterior a la fecha de inicio";
			else{
				if ($fechaDos[2]==$fechaUno[2] && $fechaUno[1]==$fechaDos[1] && $fechaDos[0]<$fechaUno[0]) {
					$erroresEmp[]="La fecha fin no puede ser anterior a la fecha de inicio";
				}
			}
		}


		if(!checkdate($fechaDos[1], $fechaDos[0], $fechaDos[2])){
			$erroresEmp[]="La fecha de fin no tiene un formato correcto";
		}


	}

	if(!checkdate($fechaUno[1], $fechaUno[0], $fechaUno[2])){
			$erroresEmp[]="La fecha de inicio no tiene un formato correcto";
		}







	


		return $erroresEmp;

		}

?>


