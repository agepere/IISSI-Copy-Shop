<?php
session_start();
//Comprobamos que ha llegado a la pagina rellando el formulario

	require_once("gestionBD.php");
	require_once("gestionarEmpleados.php");

if(isset($_SESSION["formularioEmp"])){
	$nuevoEmpleado=$_SESSION["formularioEmp"];
	$_SESSION["formularioEmp"] = null;
	$_SESSION["erroresEmp"] = null;
}

//En caso contrario se le redirige al formulario
else
header("location: formularioEmpleados.php");

// Función para formatear una fecha al formato de Oracle
	function getFechaFormateada($fecha){
		$fechaNacimiento = date('d/m/Y', strtotime($fecha));
		return $fechaNacimiento;
	}

	$conexion = crearConexionBD(); 

?>





<!DOCTYPE html>
<html>
<head>
	<title>Exito Alta de Empleado</title>
</head>
<body>
		 <?php include_once("header.php"); ?>
		<h2>El nuevo empleado ha sido dado de alta con éxito con los siguientes datos:</h2>
<ol>
		<li>Dni: <?php echo  $nuevoEmpleado["DNI"]?> </li>
		<li>Nombre: <?php echo  $nuevoEmpleado["Nombre"]?></li>
		<li>Apellidos: <?php echo  $nuevoEmpleado["Apellidos"]?></li>
		<li>Email: <?php echo  $nuevoEmpleado["Email"]?></li>
		<li>Direccion: <?php echo  $nuevoEmpleado["Direccion"]?></li>
		<li>Edad: <?php echo  $nuevoEmpleado["Edad"]?></li>

		<li>Telefono: <?php echo  $nuevoEmpleado["Telefono"]?></li>
		<li>Nick: <?php echo  $nuevoEmpleado["Nickname"]?></li>
		<li>Pass: <?php echo  $nuevoEmpleado["Password"]?></li>
		<li>Confirm pass: <?php echo  $nuevoEmpleado["ConfirmarPassword"]?></li>
		<li>Fecha Inicio: <?php echo  getFechaFormateada($nuevoEmpleado["FechaInicio"])?></li>
		<li>Fecha Fin: <?php echo  getFechaFormateada($nuevoEmpleado["FechaFin"])?></li>
	</ol><br>
	<?php 
	if (alta_empleado($conexion, $nuevoEmpleado)) { 
				echo "Empleado añadido a la base de datos correctamente. ";
			}
			else{
				$_SESSION["excepcion"]="Hubo un error al añadir el empleado a la base de datos, probablemente ya existiera. Pulse <a href='formularioEmpleados.php'>aqui</a> para volver al formulario.";
				header("location: excepcion.php");
			}
		?>

	  Pulsa <a href="formularioEmpleados.php">aquí</a> para volver al formulario de altas de usuarios.

	  <?php include_once("footer.php"); ?>

</body>
</html>