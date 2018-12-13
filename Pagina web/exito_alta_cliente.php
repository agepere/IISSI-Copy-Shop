<?php
session_start();
//Comprobamos que ha llegado a la pagina rellenando el formulario

require_once("gestionBD.php");
require_once("gestionarClientes.php");

if(isset($_SESSION["formularioClientes"])){
	$nuevoCliente=$_SESSION["formularioClientes"];
	$_SESSION["formularioClientes"] = null;
	$_SESSION["erroresCliente"] = null;
}

//En caso contrario se le redirige al formulario
else
header("location: formularioClientes.php");

	
	$conexion=crearConexionBD();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Exito Alta de Cliente</title>
</head>
<body>
		 <?php include_once("header.php"); ?>
		<h2>El nuevo cliente ha sido dado de alta con éxito con los siguientes datos:</h2>
<ul>
		<li>NIF: <?php echo  $nuevoCliente["NIF"]?> </li>
		<li>Nombre: <?php echo  $nuevoCliente["Nombre"]?></li>
		<li>Apellidos: <?php echo  $nuevoCliente["Apellidos"]?></li>
		<li>Email: <?php echo  $nuevoCliente["Email"]?></li>
		<li>Dirección: <?php echo  $nuevoCliente["Direccion"]?></li>
		<li>Telefono: <?php echo  $nuevoCliente["Telefono"]?></li>
		<li>Tipo: <?php echo  $nuevoCliente["Tipo"]?></li>
		<li>Nick: <?php echo  $nuevoCliente["Nickname"]?></li>
		<li>Pass: <?php echo  $nuevoCliente["Password"]?></li>
		<li>Confirm pass: <?php echo  $nuevoCliente["ConfirmarPassword"]?></li>
		
	</ul><br>

	<?php 
	if (alta_cliente($conexion, $nuevoCliente)) { 
				echo "<p> El nuevo cliente ha sido añadido a la base de datos correctamente.</p><br>";
			}
			else{
				echo "<h2> Los datos añadidos en el formulario son correctos pero hubo un fallo al añadirlo en la base de datos. Lo que significa que el empleado ya existía.</h2>";
			}
		?>

	  Pulsa <a href="Pagina inicio.php">aquí</a> para volver a la página de inicio e iniciar sesión.

	  <?php include_once("footer.php"); 
	  cerrarConexionBD($conexion);?>

</body>
</html>